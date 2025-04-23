<?php
namespace App\Domain\Order;

use App\Models\Products;

class OrderEntity
{
    public array $items = [];
    public float $total = 0;

    public function __construct(
        public ?int $clientId,
        public string $origin,
        array $rawItems
    ) {
        foreach ($rawItems as $item) {
            $product = Products::find($item['product_id']);
            if (!$product) continue;

            $this->items[] = [
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $item['quantity'],
            ];

            $this->total += $product->price * $item['quantity'];
        }
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->clientId,
            'total' => 0,
            'status' => 'recebido',
            'origin' => $this->origin,
        ];
    }
}
