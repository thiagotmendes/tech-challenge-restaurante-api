<?php
namespace App\Repositories\Eloquent;

use App\Domain\Client\ProductEntity;
use App\Models\Products;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductsRepository implements ProductRepositoryInterface
{

    public function save(ProductEntity $product): void
    {
        // TODO: Implement save() method.
        Products::create([
            'name' => $product->name,
            'description' => $product->description,
            'image' => $product->image,
            'price' => $product->price,
            'discount' => $product->discount,
            'active' => $product->active,
            'stockQuantity' => $product->stockQuantity,
            'category' => $product->category
        ]);
    }

    public function update(ProductEntity $product, int $id): void
    {

        // TODO: Implement update() method.
        $existing = Products::find($id);

        if ($existing) {
            $existing->update([
                'name' => $product->name,
                'description' => $product->description,
                'image' => $product->image,
                'price' => $product->price,
                'discount' => $product->discount,
                'active' => $product->active,
                'stock_quantity' => $product->stockQuantity,
                'category_id' => $product->category
            ]);
        }
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
        Products::destroy($id);
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
        return Products::all()
            ->map(fn ($product) => new ProductEntity(
                $product->id,
                $product->name,
                $product->description,
                $product->image,
                $product->price,
                $product->discount,
                $product->active,
                $product->stock_quantity,
                $product->category_id
            ))
            ->toArray();
    }

    public function findById(int $id): ?array
    {
        $product = Products::find($id);
        return $product ? $product->toArray() : null;
    }

    public function findByCategory(string $category): array
    {
        // TODO: Implement findByCategory() method.
        return Products::where('category_id', $category)
            ->get()
            ->map(fn ($product) => new ProductEntity(
                $product->id,
                $product->name,
                $product->description,
                $product->image,
                $product->price,
                $product->discount,
                $product->active,
                $product->stock_quantity,
                $product->category_id
            ))
            ->toArray();
    }
}
