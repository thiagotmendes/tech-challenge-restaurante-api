<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            // Lanches
            [
                'name' => 'X-Burguer',
                'description' => 'Hambúrguer com queijo, alface e tomate',
                'image' => 'https://source.unsplash.com/featured/?burger',
                'price' => 19.90,
                'discount' => 0.00,
                'active' => true,
                'stock_quantity' => 100,
                'category_id' => 1, // Lanche
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'X-Bacon',
                'description' => 'Hambúrguer com queijo e bacon crocante',
                'image' => 'https://source.unsplash.com/featured/?baconburger',
                'price' => 24.90,
                'discount' => 2.00,
                'active' => true,
                'stock_quantity' => 80,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Bebidas
            [
                'name' => 'Refrigerante Lata',
                'description' => 'Lata de 350ml, diversos sabores disponíveis.',
                'image' => 'https://source.unsplash.com/featured/?soda',
                'price' => 5.00,
                'discount' => 0.00,
                'active' => true,
                'stock_quantity' => 200,
                'category_id' => 3, // Bebida
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Suco Natural',
                'description' => 'Suco natural de frutas da estação.',
                'image' => 'https://source.unsplash.com/featured/?juice',
                'price' => 7.50,
                'discount' => 0.50,
                'active' => true,
                'stock_quantity' => 150,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Sobremesas
            [
                'name' => 'Pudim de Leite',
                'description' => 'Sobremesa tradicional, com calda de caramelo.',
                'image' => 'https://source.unsplash.com/featured/?pudding',
                'price' => 6.90,
                'discount' => 0.00,
                'active' => true,
                'stock_quantity' => 50,
                'category_id' => 4, // Sobremesa
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Brownie com Sorvete',
                'description' => 'Brownie de chocolate servido com sorvete de baunilha.',
                'image' => 'https://source.unsplash.com/featured/?brownie',
                'price' => 9.90,
                'discount' => 1.00,
                'active' => true,
                'stock_quantity' => 40,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Acompanhamentos
            [
                'name' => 'Batata Frita',
                'description' => 'Porção de batata frita crocante.',
                'image' => 'https://source.unsplash.com/featured/?fries',
                'price' => 7.00,
                'discount' => 0.00,
                'active' => true,
                'stock_quantity' => 120,
                'category_id' => 2, // Acompanhamento
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anéis de Cebola',
                'description' => 'Cebolas empanadas e crocantes.',
                'image' => 'https://source.unsplash.com/featured/?onionrings',
                'price' => 8.00,
                'discount' => 0.50,
                'active' => true,
                'stock_quantity' => 70,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
