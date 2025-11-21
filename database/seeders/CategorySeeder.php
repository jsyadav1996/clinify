<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Medical Equipment', 'description' => 'Various medical devices and equipment'],
            ['name' => 'Pharmaceuticals', 'description' => 'Medications and pharmaceutical products'],
            ['name' => 'Supplies', 'description' => 'General medical and office supplies'],
            ['name' => 'Diagnostic Tools', 'description' => 'Tools and devices for medical diagnosis'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
