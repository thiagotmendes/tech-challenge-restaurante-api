<?php
namespace App\Repositories\Redis;

use App\Repositories\Contracts\OrderStepRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class RedisOrderStepRepository implements OrderStepRepositoryInterface
{
    public function getSteps(string $token): array
    {
        return json_decode(Redis::get("order_draft:$token"), true) ?? [];
    }

    public function saveSteps(string $token, array $steps): void
    {
        Redis::setex("order_draft:$token", 60 * 60 * 24, json_encode($steps));
    }

    public function exists(string $token): bool
    {
        return Redis::exists("order_draft:$token") > 0;
    }

    public function clear(string $token): void
    {
        Redis::del("order_draft:$token");
    }
}
