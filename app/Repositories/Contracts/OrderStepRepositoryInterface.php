<?php
namespace App\Repositories\Contracts;

interface OrderStepRepositoryInterface
{
    public function getSteps(string $token): array;

    public function saveSteps(string $token, array $steps): void;
}
