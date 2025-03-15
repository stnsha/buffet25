<?php

namespace App\Jobs;

use App\Models\OrderDetails;
use App\Models\Capacity;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CapacityPaxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('CRON starting...');
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

            $capacity->total_paid = $total_paid;
            $available_capacity = $full_capacity - $total_paid;
            $capacity->available_capacity = $available_capacity;
            if ($available_capacity < 10) {
                $capacity->status = 2;
            }
            $capacity->save();
        }
        Log::info('Done updating capacities..');
        Log::info('Update payment confirmation starting...');
        $payment_confirmations = PaymentConfirmation::with('order')
            ->where('status', 1)
            ->get();

        foreach ($payment_confirmations as $pc) {
            if ($pc->order) {
                switch ($pc->status) {
                    case 1: //Approved
                        $status = 2; //Paid
                        break;
                    case 2: //Pending
                        $status = 1; //Reserved
                        break;
                    case 3: //Failed
                        $status = 4; //Failed
                        break;
                    default:
                        $status = 4;
                        break;
                }

                if ($pc->order->status != $status) {
                    $pc->order->status = $status;
                    $pc->order->fpx_id = $pc->bill_code;
                }

                if ($pc->order->fpx_id === null && $status == 2) {
                    $pc->order->fpx_id = $pc->bill_code;
                    $pc->order->status = $status;
                }
                $pc->order->save();
                $pc->save();
            }
        }
        Log::info('Done updating payment confirmation..');
        Log::info('Update delete older failed orders starting...');
        $orders = Order::whereIn('status', [1, 4])
            ->where('created_at', '<', Carbon::now()->subDay()) // Orders older than 1 day
            ->get();

        foreach ($orders as $order) {
            $order->order_details()->delete(); // Delete related order details
            $order->delete(); // Delete the order
        }
        Log::info('Done delete older failed orders..');
        Log::info('Update venue older date status starting...');
        Capacity::where('status', '!=', 2)
            ->where('venue_date', '<', Carbon::today())
            ->update(['status' => 2]);
        Log::info('Done venue older date status..');
        Log::info('CRON finished.');
    }
}
