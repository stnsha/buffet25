<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Capacity;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Price;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    public function arena()
    {
        return redirect('/');
        // $prices = Price::where('venue_id', 1)->get();
        // $dates = Capacity::where('venue_id', 1)->where('status', 1)->get();
        // $this->updateStatus();
        // return view('forms.arena', compact('prices', 'dates'));
    }

    public function chermin()
    {

        return redirect('/');
        // $prices = Price::where('venue_id', 2)->get();
        // $dates = Capacity::where('venue_id', 2)->where('status', 1)->get();
        // $arr = [];
        // foreach ($dates as $date) {
        //     // $isWeekday = Carbon::parse($date->venue_date)->isWeekday();
        //     $display_date = Carbon::parse($date->venue_date)->locale('ms_MY')->format('l, d M Y, g:i a');

        //     $arr[] = [
        //         'date_id' => $date->id,
        //         'date' => $display_date,
        //         'available_capacity' => $date->available_capacity,
        //         'prices' => $prices->map(function ($price) use ($date) {
        //             $isDiscounted = in_array($price->id, [7, 10]);
        //             return [
        //                 'id' => $price->id,
        //                 'name' => $price->name,
        //                 'current_price' => $isDiscounted ? 49 : $price->normal_price,
        //                 'description' => $price->description,
        //                 'available_capacity' => $date->available_capacity,
        //             ];
        //         })->toArray(),
        //     ];
        // }
        // $this->updateStatus();
        // return view('forms.chermin', compact('arr', 'prices'));
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
                $capacity = Capacity::find($request->selected_date);
                $capacity_id = $capacity->id;
                $venue_id = $capacity->venue_id;
                $subtotal = $request->subtotal;

                if ($request['3_quantity'] != null) {
                    $disc_dewasa = 0;
                    $disc_dewasa += $request['3_quantity'] * 7;
                    $subtotal += $disc_dewasa;
                } else if ($request['7_quantity'] != null) {
                    $disc_dewasa = 0;
                    $disc_dewasa += $request['7_quantity'] * 6;
                    $subtotal += $disc_dewasa;
                }
                $total = $request->subtotal;

                $venue = Venue::find($venue_id);
                $code = $venue->code;

                /**
                 * 1 - Reserved
                 * 2 - Paid
                 * 3 - Pending
                 * 4 - Fail
                 */
                $order = Order::create([
                    'ref_id' => $code,
                    'customer_id' => $customer_id,
                    'venue_id' => $capacity_id,
                    'subtotal' => $subtotal,
                    'discount_total' => $disc_dewasa,
                    'total' => $total,
                    'fpx_id' => null,
                    'status' => 1, //1 = Reserved
                ]);

                $order_id = $order->id;

                $ref_id = $code . str_pad($order_id, 5, '0', STR_PAD_LEFT);
                $order->ref_id = $ref_id;
                $order->save();

                foreach ($validated as $key => $value) {
                    if (preg_match('/(\d+)_quantity/', $key, $matches)) {
                        if ($value != 0) {
                            $price_id = $matches[1];
                            $price = Price::find($price_id);
                            $og_price = ($price_id == 3 || $price_id == 9) ? 48 : (($price_id == 7 || $price_id == 10) ? 49 : $price->normal_price);
                            if ($price_id == 9) {
                                $free = floor($value / 20);
                                $value += $free;
                            }

                            if ($price_id == 10) {
                                $value *= 21;
                            }

                            OrderDetails::create([
                                'order_id' => $order_id,
                                'price_id' => $price_id,
                                'price' => $og_price,
                                'quantity' => $value,
                                'subtotal' => $validated["{$price_id}_price"] ?? 0,
                            ]);
                        }
                    }
                }

                DB::commit();
                return redirect()->route('payment.createBill', $order_id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to store order: ' . $e->getMessage()])
                ->withInput();
            // return response()->json(['error' => 'Failed to store order', 'message' => $e->getMessage()], 500);
        }
    }

    public function completed($order_id)
    {
        $order = Order::find($order_id);

        return view('forms.completed', compact('order'));
    }

    public function failed()
    {
        return view('forms.failed');
    }

    public function updateStatus()
    {
        Log::info('Updating capacities with past venue dates on form');

        $updated = Capacity::where('status', '!=', 2)
            ->where('venue_date', '<', Carbon::today())
            ->update(['status' => 2]);

        Log::info('Updated capacity status on form', ['count' => $updated]);
    }

    public function fin()
    {
        return view('welcome');
    }
}
