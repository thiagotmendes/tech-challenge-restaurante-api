<?php
namespace App\Services\Product;

use App\Domain\Product\ProductEntity;
use App\Repositories\Contracts\ProductRepositoryInterface;

class RegisterProductService
{
    public function __construct(protected ProductRepositoryInterface $repository){}

    public function handle( array $data ): ProductEntity
    {

        $product = new ProductEntity(
            null,
            $data['name'],
            $data['description'],
            $data['image'],
            $data['price'],
            $data['discount'],
            $data['active'],
            $data['stockQuantity'],
            $data['category']
        );

        $this->repository->save($product);

        return $product;
    }
}
