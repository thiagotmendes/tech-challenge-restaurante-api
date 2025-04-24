<?php

namespace App\Services\Order;

use App\Events\OrderReady;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class KitchenOrderService
{
    public function listPending(?string $status = null): Collection
    {
        $query = Order::with(['items.product'])
            ->orderBy('created_at', 'asc');

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['recebido', 'em_preparacao']);
        }

        return $query->get();
    }

    public function updateStatus(int $orderId, string $status): void
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        Log::info("Status do pedido #{$orderId} atualizado para {$status}");

        if ($status === 'pronto') {
            event(new OrderReady($order));
        }
    }
}
