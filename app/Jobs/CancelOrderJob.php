<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CancelOrderJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        Order::query()->where('status' , OrderStatus::FOR_PAYMENT)->chunk(100, function ($orders)  {
            foreach ($orders as $order) {
                if ($order->created_at->diffInMinutes(now()) > 2) {
                    $order->update(['status' => OrderStatus::CANCELED]);
                }
            }
        });
    }
}
