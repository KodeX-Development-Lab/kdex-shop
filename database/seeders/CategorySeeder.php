<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $category = ['Phone', 'Laptop', 'Shoe', 'Shirt', 'Toy'];
        $images = ['phone.webp', 'laptop.webp', 'shoe.avif', 'shirt.webp', 'toy.jpg'];

        foreach ($category as $key => $c) {
            Category::create([
                'name' => $category[$key], // Use corresponding Myanmar name
                'image' => $images[$key],
            ]);
        }
    }
}
