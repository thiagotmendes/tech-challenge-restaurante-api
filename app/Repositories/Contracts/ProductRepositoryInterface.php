<?php
namespace App\Repositories\Contracts;

use App\Domain\Client\ProductEntity;

interface ProductRepositoryInterface
{
    public function save(ProductEntity $product): void;

    public function update(ProductEntity $product, int $id): void;

    public function delete(int $id): void;

    public function getAll(): array;

    public function findById(int $id): ?array;

    public function findByCategory(string $category): array;
}
