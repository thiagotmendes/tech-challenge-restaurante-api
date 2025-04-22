<?php
namespace App\Services\Product;

use App\Repositories\Contracts\ProductRepositoryInterface;

class FindProductByCategory
{
    public function __construct(protected ProductRepositoryInterface $repository){}

    public function handle(string $category): array
    {
        $products = $this->repository->findByCategory($category);

        if (empty($products)) {
            return [
                'success' => false,
                'message' => 'Nenhum produto encontrado.'
            ];
        }

        return $products;
    }
}
