<?php
namespace App\Services\Product;

use App\Repositories\Contracts\ProductRepositoryInterface;

class DeleteProductService
{
    public function __construct(protected ProductRepositoryInterface $repository){}

    public function handle(int $id): void
    {
        $this->repository->delete($id);
    }
}
