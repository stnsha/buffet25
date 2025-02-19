<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'baby_chair' => 'required|integer',
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
                    'baby_chair' => $data['baby_chair'],
                    'min_capacity' => 1,
                    'available_capacity' => $data['full_capacity'],
                    'available_bchair' => $data['baby_chair'],
                    'status' => $data['status'],
                ];

                // Increment to the next day
                $from_date->addDay();
            }

            if (!empty($capacity_data)) {
                Capacity::insert($capacity_data);
            }
        }
        exit;
        return redirect()->route('venue.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Capacity $capacity)
    {
        //
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
    public function update(Request $request, Capacity $capacity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capacity $capacity)
    {
        //
    }
}