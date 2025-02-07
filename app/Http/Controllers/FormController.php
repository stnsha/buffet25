<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Capacity;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            if ($validated) {
                // dd($validated);
                $cname = $request->nama;
                $cphone = $request->phone;
                $request->email != null ? $cemail = $request->email : null;

                $c_exist = Customer::where('name', $cname)->where('phone_no', $cphone)->first();
                $customer_id = 0;
                if ($c_exist) {
                    $customer_id = $c_exist->id;
                } else {
                    $customer = Customer::create([
                        'name' => $cname,
                        'phone_no' => $cphone,
                        'email' => $cemail
                    ]);

                    $customer_id = $customer->id;
                }
                $venue_id = Capacity::find($request->selected_date)->value('venue_id');
                $subtotal = $request->subtotal;
                $disc_dewasa = $request['2_quantity'] * 7;
                $total = $subtotal - $disc_dewasa;

                $is_bchair = $request->baby_chair != 0 ? 1 : 0;
                $total_bchair = $is_bchair != 0 ? $request->baby_chair : 0;
                $order = Order::create([
                    'customer_id' => $customer_id,
                    'venue_id' => $venue_id,
                    'subtotal' => $subtotal,
                    'discount_total' => $disc_dewasa,
                    'total' => $total,
                    'fpx_id' => null,
                    'is_chair' => $is_bchair,
                    'total_chair' => $total_bchair,
                    'status' => 1, //1 = Reserved
                ]);

                $order_id = $order->id;

                foreach ($validated as $key => $value) {
                    if (preg_match('/(\d+)_quantity/', $key, $matches)) {
                        $price_id = $matches[1];
                        $price = Price::find($price_id);
                        $og_price = $price_id == 2 ? 58 : $price->normal_price;

                        OrderDetails::create([
                            'order_id' => $order_id,
                            'price_id' => $price_id,
                            'price' => $og_price,
                            'quantity' => $value,
                            'subtotal' => $validated["{$price_id}_price"] ?? 0,
                        ]);
                    }
                }

                DB::commit();
                return redirect()->route('form.arena');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store order', 'message' => $e->getMessage()], 500);
        }
    }
}
