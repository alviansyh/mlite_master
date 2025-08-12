<?php
namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Database\Seeder;

class DemoMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kategori dan kode unit yang sudah ada
        $makananPokok = MaterialCategory::where('name', 'Makanan Pokok')->first()->id;
        $laukPauk     = MaterialCategory::where('name', 'Lauk Pauk')->first()->id;
        $sayuran      = MaterialCategory::where('name', 'Sayur-sayuran')->first()->id;
        $buahBuahan   = MaterialCategory::where('name', 'Buah-buahan')->first()->id;
        $minuman      = MaterialCategory::where('name', 'Minuman')->first()->id;

        $products = [
            // Makanan Pokok
            [
                'code'                => 'BR-001',
                'name'                => 'Beras Medium',
                'description'         => 'Beras jenis medium kualitas bagus, cocok untuk konsumsi harian.',
                'material_category_id' => $makananPokok,
                'base_unit_code'      => 'kg',
                'minimum_stock'       => 100,
            ],
            [
                'code'                => 'RO-002',
                'name'                => 'Roti Tawar Gandum',
                'description'         => 'Roti gandum utuh, kaya serat.',
                'material_category_id' => $makananPokok,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 50,
            ],
            // Lauk Pauk
            [
                'code'                => 'TL-003',
                'name'                => 'Telur Ayam',
                'description'         => 'Telur ayam negeri, bersih dan segar.',
                'material_category_id' => $laukPauk,
                'base_unit_code'      => 'butir',
                'minimum_stock'       => 500,
            ],
            [
                'code'                => 'IK-004',
                'name'                => 'Ikan Tongkol',
                'description'         => 'Ikan tongkol segar beku.',
                'material_category_id' => $laukPauk,
                'base_unit_code'      => 'kg',
                'minimum_stock'       => 30,
            ],
            [
                'code'                => 'TM-005',
                'name'                => 'Tempe',
                'description'         => 'Tempe kedelai bungkus daun.',
                'material_category_id' => $laukPauk,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 100,
            ],
            // Sayur-sayuran
            [
                'code'                => 'SB-006',
                'name'                => 'Bayam Hijau',
                'description'         => 'Bayam segar, satu ikat.',
                'material_category_id' => $sayuran,
                'base_unit_code'      => 'ikat',
                'minimum_stock'       => 20,
            ],
            [
                'code'                => 'WT-007',
                'name'                => 'Wortel',
                'description'         => 'Wortel segar lokal.',
                'material_category_id' => $sayuran,
                'base_unit_code'      => 'kg',
                'minimum_stock'       => 25,
            ],
            // Buah-buahan
            [
                'code'                => 'PS-008',
                'name'                => 'Pisang Kepok',
                'description'         => 'Pisang lokal, satu buah.',
                'material_category_id' => $buahBuahan,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 150,
            ],
            // Minuman
            [
                'code'                => 'SU-009',
                'name'                => 'Susu UHT Coklat 200ml',
                'description'         => 'Susu UHT dalam kemasan kotak.',
                'material_category_id' => $minuman,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 50,
            ],
            [
                'code'                => 'AM-010',
                'name'                => 'Air Mineral Botol',
                'description'         => 'Air mineral dalam kemasan botol.',
                'material_category_id' => $minuman,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 50,
            ],
        ];

        foreach ($products as $productData) {
            Material::create($productData);
        }
    }
}
