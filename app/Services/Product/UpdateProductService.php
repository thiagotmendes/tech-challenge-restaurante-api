<?php
namespace App\Services\Product;

use App\Domain\Product\ProductEntity;
use App\Repositories\Contracts\ProductRepositoryInterface;

class UpdateProductService
{
    public function __construct(protected ProductRepositoryInterface $repository){}


    public function handle(array $data, int $id): ProductEntity
    {
        $product = new ProductEntity(
            $id,
            $data['name'],
            $data['description'],
            $data['image'],
            $data['price'],
            $data['discount'],
            $data['active'],
            $data['stockQuantity'],
            $data['category']
        );

        $this->repository->update($product, $id);

        return $product;
    }
}
