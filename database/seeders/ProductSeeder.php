<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'This is a sample product.'
        ]);
    }
}
