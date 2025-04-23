<?php
namespace App\Services\Order;

use App\Domain\Order\OrderEntity;

class OrderFactoryService
{
    public function build(?int $clientId, string $origin, array $items): OrderEntity
    {
        return new OrderEntity($clientId, $origin, $items);
    }
}
