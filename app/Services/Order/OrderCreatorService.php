<?php
namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Domain\Order\OrderEntity;

class OrderCreatorService
{
    public function persist(OrderEntity $orderEntity, string $token): Order
    {
        $order = Order::create(array_merge(
            $orderEntity->toArray(),
            ['token' => $token]
        ));

        foreach ($orderEntity->getItems() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $order->update(['total' => $orderEntity->getTotal()]);

        return $order;
    }
}
