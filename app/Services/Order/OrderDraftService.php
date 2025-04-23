<?php
namespace App\Services\Order;

use Illuminate\Support\Facades\Redis;

class OrderDraftService
{
    public function exists(string $token): bool
    {
        return Redis::exists("order_draft:$token") > 0;
    }

    public function get(string $token): array
    {
        return json_decode(Redis::get("order_draft:$token"), true) ?? [];
    }

    public function clear(string $token): void
    {
        Redis::del("order_draft:$token");
    }
}
