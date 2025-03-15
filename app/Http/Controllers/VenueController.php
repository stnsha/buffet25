<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\OrderDetails;
use App\Models\Venue;
use Illuminate\Http\Request;

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
        $order_details = OrderDetails::with('order')
            ->whereHas('order', function ($query) {
                $query->where('status', 2);
            })
            ->get()
            ->groupBy('order_id')
            ->map(function ($details) {
                return [
                    'venue_id' => $details->first()->order->venue_id,
                    'total_quantity' => $details->sum('quantity')
                ];
            });

        $total_by_capacity = collect($order_details)
            ->groupBy('venue_id')
            ->map(function ($orders) {
                return [
                    'total_quantity' => $orders->sum('total_quantity')
                ];
            });

        foreach ($total_by_capacity as $capacity_id => $tc) {
            $capacity = Capacity::find($capacity_id);
            $available_capacity = $capacity->available_capacity;
            $total_paid = $capacity->total_paid;

            $total_paid = $tc['total_quantity'];
            $updated_full_capacity = $available_capacity + $total_paid;

            $capacity->full_capacity = $updated_full_capacity;
            $capacity->total_paid = $total_paid;

            if ($total_paid == $updated_full_capacity) {
                $capacity->status = 2;
            }
            $capacity->save();
        }
    }
}