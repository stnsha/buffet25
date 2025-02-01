<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Venue;
use Illuminate\Http\Request;

class PriceController extends Controller
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

        return view('prices.create', compact('venue_id', 'venue_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|integer',
            'price_name' => 'required|array',
            'price' => 'required|array',
            'price_name.*' => 'required|string',
            'price.*' => 'required|numeric',
        ]);

        foreach ($request->price_name as $index => $name) {
            Price::create([
                'venue_id' => $request->venue_id,
                'name' => $name,
                'normal_price' => $request->price[$index],
            ]);
        }
        exit;
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        //
    }
}
