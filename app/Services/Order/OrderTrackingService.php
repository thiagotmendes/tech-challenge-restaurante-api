<?php
namespace App\Services\Order;

use App\Models\Order;

class OrderTrackingService
{
    public function handle(string $token): ?Order
    {
        return Order::with('items.product')
            ->where('token', $token)
            ->first();
    }
}
