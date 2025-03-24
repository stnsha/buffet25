<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\OrderDetails;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($venue_id)
    {
        $venue = Venue::find($venue_id);
        $this->calcPax();
        return view('venues.index', compact('venue', 'venue_id'));
    }

    public function calcPax()
    {
        Log::debug('calcPax started.');

        $order_details = OrderDetails::with('order')
            ->whereHas('order', function ($query) {
                $query->where('status', 2);
            })
            ->get();

        Log::debug('Fetched order details.', ['count' => $order_details->count()]);

        $grouped_orders = $order_details->groupBy('order_id');

        Log::debug('Grouped orders by order_id.', ['group_count' => $grouped_orders->count()]);

        $mapped_orders = $grouped_orders->map(function ($details) {
            return [
                'venue_id' => $details->first()->order->venue_id,
                'total_quantity' => $details->sum('quantity')
            ];
        });

        Log::debug('Mapped orders to venue_id and total_quantity.', ['mapped_orders' => $mapped_orders]);

        $total_by_capacity = collect($mapped_orders)
            ->groupBy('venue_id')
            ->map(function ($orders) {
                return [
                    'total_quantity' => $orders->sum('total_quantity')
                ];
            });

        Log::debug('Total quantity grouped by venue_id.', ['total_by_capacity' => $total_by_capacity]);

        foreach ($total_by_capacity as $capacity_id => $tc) {
            Log::debug("Processing capacity_id: $capacity_id", ['total_quantity' => $tc['total_quantity']]);

            $capacity = Capacity::where('id', $capacity_id)->whereDate('venue_date', '>', Carbon::today('Asia/Kuala_Lumpur')->startOfDay())->first();

            if (!$capacity) {
                // Log::error("Capacity not found for ID: $capacity_id");
                continue;
            }

            $full_capacity = $capacity->full_capacity;
            $total_paid = $tc['total_quantity'];

            Log::debug("Capacity details", [
                'capacity_id' => $capacity_id,
                'full_capacity' => $full_capacity,
                'total_paid' => $total_paid
            ]);

            $capacity->total_paid = $total_paid;
            $available_capacity = $full_capacity - $total_paid;
            $capacity->available_capacity = $available_capacity;

            Log::debug("Updated available_capacity", [
                'capacity_id' => $capacity_id,
                'available_capacity' => $available_capacity
            ]);

            if ($available_capacity < 1) {
                $capacity->status = 2;
                Log::debug("Marked capacity as sold out (status = 2)", ['capacity_id' => $capacity_id]);
            }

            $capacity->save();
            Log::debug("Capacity updated and saved.", ['capacity_id' => $capacity_id]);
        }

        Log::debug('calcPax completed.');
    }
}
