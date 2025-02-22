<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'order_details'])->get();

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
