<?php
namespace App\Domain\Product;
class ProductEntity
{
    /**
     * @param string $name
     * @param string $description
     * @param string $image
     * @param float $price
     * @param float $discount
     * @param bool $active
     * @param int $stockQuantity
     * @param string $category
     */
    public function __construct(
        public ?int $id,
        public string $name,
        public string $description,
        public string $image,
        public float $price,
        public float $discount,
        public bool $active,
        public int $stockQuantity,
        public ?int $category = null
    ){}
}
