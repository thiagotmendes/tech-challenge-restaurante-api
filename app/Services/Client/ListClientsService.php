<?php
namespace App\Services\Client;

use App\Repositories\Contracts\ClientRepositoryInterface;

class ListClientsService
{
    public function __construct(
        protected ClientRepositoryInterface $repository
    ) {}

    public function handle(): array
    {
        return $this->repository->getAll();
    }
}
