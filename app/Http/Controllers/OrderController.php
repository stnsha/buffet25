<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::whereIn('status', [2, 4])
            ->with(['customer', 'order_details', 'payment_confirmation'])
            ->orderBy('created_at', 'desc')
            ->get();

        $this->updateStatus();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $venue_id = $order->capacity->venue_id;
        $capacities = Capacity::where('venue_id', $venue_id)->get();
        return view('orders.edit', compact('order', 'capacities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $old_venue_id = $order->venue_id;
        $new_venue_id = $request->capacity_id;

        $total_pax = 0;
        foreach ($order->order_details as $odt) {
            $total_pax += $odt->quantity;
        }

        $old_capacity = Capacity::find($old_venue_id);
        $old_capacity->available_capacity += $total_pax;
        $old_capacity->total_paid -= $total_pax;

        $new_capacity = Capacity::find($new_venue_id);
        if ($new_capacity->available_capacity < $total_pax) {
            return redirect()->back()->with('error', 'Not enough capacity in the new date.');
        }

        $new_capacity->available_capacity -= $total_pax;
        $new_capacity->total_paid += $total_pax;

        $order->venue_id = $new_venue_id;
        $old_capacity->save();
        $new_capacity->save();
        $order->save();
        $message = '#' . $order->ref_id . ' successfully updated!';
        return redirect()->route('order.index')->with('success', $message);
    }

    public function updateStatus()
    {
        Log::info('Starting updateStatus method');

        $payment_confirmations = PaymentConfirmation::with('order')
            ->where('status', 1)
            ->get();

        Log::info('Fetched payment confirmations', ['count' => $payment_confirmations->count()]);

        foreach ($payment_confirmations as $pc) {
            if ($pc->order) {
                Log::info('Processing payment confirmation', ['id' => $pc->id, 'order_id' => $pc->order->id, 'current_status' => $pc->status]);

                switch ($pc->status) {
                    case 1: // Approved
                        $status = 2; // Paid
                        break;
                    case 2: // Pending
                        $status = 1; // Reserved
                        break;
                    case 3: // Failed
                        $status = 4; // Failed
                        break;
                    default:
                        $status = 4;
                        break;
                }

                Log::info('Determined new status', ['new_status' => $status]);

                if ($pc->order->status != $status) {
                    Log::info('Updating order status', ['order_id' => $pc->order->id, 'old_status' => $pc->order->status, 'new_status' => $status, 'bill_code' => $pc->bill_code]);
                    $pc->order->status = $status;
                    $pc->order->fpx_id = $pc->bill_code;
                }

                if ($pc->order->fpx_id === null && $status == 2) {
                    Log::info('Setting FPX ID for paid order', ['order_id' => $pc->order->id, 'bill_code' => $pc->bill_code, 'bill_code' => $pc->bill_code]);
                    $pc->order->fpx_id = $pc->bill_code;
                    $pc->order->status = $status;
                }

                $pc->order->save();
                $pc->save();
            }
        }

        Log::info('Checking for old unpaid or failed orders to delete');

        $orders = Order::whereIn('status', [1, 4])
            ->where('created_at', '<', Carbon::now()->subDay()) // Orders older than 1 day
            ->get();

        Log::info('Found orders to delete', ['count' => $orders->count()]);

        foreach ($orders as $order) {
            Log::info('Deleting order', ['order_id' => $order->id]);
            $order->order_details()->delete(); // Delete related order details
            $order->delete(); // Delete the order
        }

        Log::info('Updating capacities with past venue dates');

        $updated = Capacity::where('status', '!=', 2)
            ->where('venue_date', '<', Carbon::today())
            ->update(['status' => 2]);

        Log::info('Updated capacity status', ['count' => $updated]);
    }
}
