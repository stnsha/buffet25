<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Capacity;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($venue_id)
    {
        $venue_name = Venue::where('id', $venue_id)->value('name');

        return view('capacities.create', compact('venue_id', 'venue_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|integer|exists:venues,id',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after:from_date',
            'full_capacity' => 'required|integer',
            'status' => 'required|integer',
        ]);
        if ($validated) {
            $data = $request->only(['venue_id', 'from_date', 'to_date', 'full_capacity', 'baby_chair', 'status']);

            $from_date = Carbon::parse($data['from_date']);
            $to_date = Carbon::parse($data['to_date']);

            $capacity_data = [];

            while ($from_date->lte($to_date)) {
                $current_date = $from_date->copy()->setTime(18, 45); // Set time to 18:45

                $existing_capacity = Capacity::where('venue_id', $data['venue_id'])
                    ->whereDate('venue_date', $current_date->toDateString()) // Compare date only
                    ->exists();

                if ($existing_capacity) {
                    $from_date->addDay();
                    continue; // Skip the current iteration
                }

                $capacity_data[] = [
                    'venue_id' => $data['venue_id'],
                    'venue_date' => $current_date,
                    'full_capacity' => $data['full_capacity'],
                    'min_capacity' => 1,
                    'available_capacity' => $data['full_capacity'],
                    'status' => $data['status'],
                ];

                // Increment to the next day
                $from_date->addDay();
            }

            if (!empty($capacity_data)) {
                Capacity::insert($capacity_data);
            }

            return redirect()->route('venue.index', $data['venue_id'])->with('success', 'New date successfully created!');
        }
    }

    /**
     * Export the specified resource.
     */
    public function export($venue_id)
    {
        $orders = Order::where('venue_id', $venue_id)->where('status', 2)->get();
        $results = [];

        $capacity = Capacity::find($venue_id);

        if ($orders) {
            foreach ($orders as $od) {
                switch ($od->status) {
                    case 1:
                        $status = 'Reserved';
                        break;
                    case 2:
                        $status = 'Paid';
                        break;
                    case 3:
                        $status = 'Pending Payment';
                        break;
                    default:
                        $status = 'Failed';
                        break;
                }
                $order_details = [];
                foreach ($od->order_details as $odt) {
                    $order_details[$od->id][] = [
                        'price_name' => $odt->hasPrice->name,
                        'price' => $odt->price,
                        'quantity' => $odt->quantity,
                        'subtotal' => $odt->subtotal
                    ];
                }

                $results[$capacity->venue->name][] = [
                    'order_id' => $od->ref_id,
                    'customer_name' => $od->customer->name ?? null,
                    'customer_phone' => $od->customer->phone_no ?? null,
                    'customer_email' => $od->customer->email ?? null,
                    'total_payment' => $od->total,
                    'toyyibpay_ref' => $od->fpx_id,
                    'status' => $status,
                    'order_details' => $order_details
                ];
            }

            $file_name = $capacity->venue->name . '-' . date('y-M-d', strtotime($capacity->venue_date)) . '.xlsx';

            return Excel::download(new OrderExport($results, $capacity->venue->name, $capacity->venue_date), $file_name);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($capacity_id)
    {
        $capacity = Capacity::find($capacity_id);

        return view('capacities.edit', compact('capacity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $capacity_id)
    {
        $capacity = Capacity::find($capacity_id);
        if ($capacity) {
            $capacity->full_capacity = $request['full_capacity'];
            $capacity->min_capacity = $request['min_capacity'];
            $capacity->available_capacity = $request['available_capacity'];
            $capacity->total_paid = $request['total_paid'];
            $capacity->total_reserved = $request['total_reserved'];
            $capacity->status = $request['status'];
            $capacity->save();

            return redirect()->route('venue.index', $capacity->venue_id)->with('success', 'Update successful!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($capacity_id)
    {
        $capacity = Capacity::find($capacity_id);
        if ($capacity) {
            $capacity->delete();
            $capacity->save();
            return redirect()->route('venue.index', $capacity->venue_id)->with('success', 'Delete successful!');
        }
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
            $full_capacity = $capacity->full_capacity;
            $total_paid = $capacity->total_paid;

            $total_paid = $tc['total_quantity'];
            $updated_capacity = $full_capacity - $total_paid;

            $capacity->available_capacity = $updated_capacity;
            $capacity->total_paid = $total_paid;

            if ($updated_capacity == 0) {
                $capacity->status = 2;
            }
            $capacity->save();
        }
    }
}