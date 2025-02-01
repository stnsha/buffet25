<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function arena()
    {
        $prices = Price::where('venue_id', 1)->get();
        $dates = Capacity::where('venue_id', 1)->get();
        return view('forms.arena', compact('prices', 'dates'));
    }

    public function chermin()
    {
        return view('forms.chermin');
    }
}
