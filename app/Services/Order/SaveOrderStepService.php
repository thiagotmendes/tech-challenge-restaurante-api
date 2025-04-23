<?php
namespace App\Services\Order;

use App\Repositories\Contracts\OrderStepRepositoryInterface;

class SaveOrderStepService
{
    public function __construct(protected OrderStepRepositoryInterface $repository) {}

    public function handle(string $token, array $stepItem): array
    {
        $steps = $this->repository->getSteps($token);
        $steps[] = $stepItem;

        $this->repository->saveSteps($token, $steps);

        return $steps;
    }
}
