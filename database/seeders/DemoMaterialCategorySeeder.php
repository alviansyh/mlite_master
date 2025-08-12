<?php
namespace Database\Seeders;

use App\Models\MaterialCategory;
use Illuminate\Database\Seeder;

class DemoMaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Makanan Pokok',
                'description' => 'Sumber karbohidrat utama sebagai energi.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Lauk Pauk',
                'description' => 'Sumber protein hewani dan nabati.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Sayur-sayuran',
                'description' => 'Sumber vitamin, mineral, dan serat.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Buah-buahan',
                'description' => 'Sumber vitamin dan mineral pelengkap.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Minuman',
                'description' => 'Untuk hidrasi dan nutrisi tambahan.',
                'is_active'   => true,
            ],
        ];

        foreach ($categories as $category) {
            MaterialCategory::create($category);
        }
    }
}
