<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        Schema::disableForeignKeyConstraints();

        // Truncate tables in reverse dependency order
        Product::truncate();
        Subcategory::truncate();
        Category::truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Run seeders
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
        ]);
    }
}
