<?php
namespace App\Services\Product;

use App\Domain\Client\ProductEntity;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ListProductsService {

    public function __construct(protected ProductRepositoryInterface $repository){}


    public function handle(): array
    {
        return $this->repository->getAll();
    }
}
