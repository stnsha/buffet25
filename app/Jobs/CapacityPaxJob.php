<?php

namespace App\Jobs;

use App\Models\OrderDetails;
use App\Models\Capacity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CapacityPaxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
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
            if (!$capacity) {
                continue;
            }

            $full_capacity = $capacity->full_capacity;
            $total_paid = $tc['total_quantity'];

            $updated_capacity = $full_capacity - $total_paid;
            $capacity->available_capacity = max($updated_capacity, 0);
            $capacity->total_paid = $total_paid;

            if ($updated_capacity <= 0) {
                $capacity->status = 2;
            }

            $capacity->save();
        }
    }
}