<?php
namespace App\Services\Product;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ShowProductService
{

    public function __construct(protected ProductRepositoryInterface $repository){}

    public function handle(int $id): array
    {
        return $this->repository->findById($id);
    }
}
