<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Lanche',
                'description' => 'Sanduíches e hambúrgueres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Acompanhamento',
                'description' => 'Porções e acompanhamentos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bebida',
                'description' => 'Bebidas geladas e sucos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sobremesa',
                'description' => 'Doces e sobremesas',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
