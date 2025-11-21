<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Medical Equipment subcategories
        $medicalEquipment = Category::where('name', 'Medical Equipment')->first();
        if ($medicalEquipment) {
            $subcategories = [
                'Stethoscopes',
                'Blood Pressure Monitors',
                'Thermometers',
                'Oxygen Equipment',
                'Wheelchairs',
            ];
            foreach ($subcategories as $name) {
                Subcategory::create([
                    'category_id' => $medicalEquipment->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => true,
                ]);
            }
        }

        // Pharmaceuticals subcategories
        $pharmaceuticals = Category::where('name', 'Pharmaceuticals')->first();
        if ($pharmaceuticals) {
            $subcategories = [
                'Pain Relief',
                'Antibiotics',
                'Vitamins & Supplements',
                'Cardiovascular',
                'Respiratory',
            ];
            foreach ($subcategories as $name) {
                Subcategory::create([
                    'category_id' => $pharmaceuticals->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => true,
                ]);
            }
        }

        // Supplies subcategories
        $supplies = Category::where('name', 'Supplies')->first();
        if ($supplies) {
            $subcategories = [
                'Bandages & Dressings',
                'Syringes & Needles',
                'Gloves',
                'Masks',
                'Cleaning Supplies',
            ];
            foreach ($subcategories as $name) {
                Subcategory::create([
                    'category_id' => $supplies->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => true,
                ]);
            }
        }

        // Diagnostic Tools subcategories
        $diagnosticTools = Category::where('name', 'Diagnostic Tools')->first();
        if ($diagnosticTools) {
            $subcategories = [
                'X-Ray Machines',
                'Ultrasound Equipment',
                'Lab Testing Kits',
                'ECG Machines',
                'Spirometers',
            ];
            foreach ($subcategories as $name) {
                Subcategory::create([
                    'category_id' => $diagnosticTools->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => true,
                ]);
            }
        }
    }
}
