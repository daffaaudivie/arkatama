<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
   
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Gadgets, devices, and electronics'],
            ['name' => 'Books', 'description' => 'Books and educational materials'],
            ['name' => 'Clothing', 'description' => 'Men and women clothing'],
            ['name' => 'Furniture', 'description' => 'Home and office furniture'],
            ['name' => 'Toys', 'description' => 'Kids and baby toys'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
