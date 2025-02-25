<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('status', 2)->with(['customer', 'order_details'])->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $payment_confirmation_id)
    {
        /**
         * $request->input('status'),
         */

        /**
         * status_id -> 1= success, 2=pending, 3=fail (from API)
         * billcode -> fpx_id
         */
        $pc = PaymentConfirmation::find($payment_confirmation_id);

        if ($pc) {
            $status = $request->input('status');
            $order = Order::find($pc->order_id);
            switch ($status) {
                case '1':
                    $order->status = 2;
                    break;
                case '3':
                    $order->status = 4;
                    break;
                default:
                    $order->status = 1;
                    break;
            }
            $order->save();

            if ($status == 1) {
                $order_details = OrderDetails::where('order_id', $order->id)->get();
                $total_quantity = $order_details->sum('quantity');

                $capacity = Capacity::find($order->venue_id);
                $new_tpaid = $capacity->total_paid + $total_quantity;
                $new_tcap = $capacity->available_capacity - $total_quantity;
                $capacity->total_paid = $new_tpaid;
                $capacity->available_capacity = $new_tcap;
                /**
                 * status = 1 ; available
                 * 2 = warning
                 * 3 = sold out
                 */

                $new_tcap < 20 ?? $capacity->status = 2;
                $new_tcap == 0 ?? $capacity->status = 3;
                $capacity->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
