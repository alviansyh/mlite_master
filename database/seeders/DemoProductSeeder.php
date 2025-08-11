<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class DemoProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kategori dan kode unit yang sudah ada
        $makananPokok = ProductCategory::where('name', 'Makanan Pokok')->first()->id;
        $laukPauk     = ProductCategory::where('name', 'Lauk Pauk')->first()->id;
        $sayuran      = ProductCategory::where('name', 'Sayur-sayuran')->first()->id;
        $buahBuahan   = ProductCategory::where('name', 'Buah-buahan')->first()->id;
        $minuman      = ProductCategory::where('name', 'Minuman')->first()->id;

        $products = [
            // Makanan Pokok
            [
                'code'                => 'BR-001',
                'name'                => 'Beras Medium',
                'description'         => 'Beras jenis medium kualitas bagus, cocok untuk konsumsi harian.',
                'product_category_id' => $makananPokok,
                'base_unit_code'      => 'kg',
                'minimum_stock'       => 100,
            ],
            [
                'code'                => 'RO-002',
                'name'                => 'Roti Tawar Gandum',
                'description'         => 'Roti gandum utuh, kaya serat.',
                'product_category_id' => $makananPokok,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 50,
            ],
            // Lauk Pauk
            [
                'code'                => 'TL-003',
                'name'                => 'Telur Ayam',
                'description'         => 'Telur ayam negeri, bersih dan segar.',
                'product_category_id' => $laukPauk,
                'base_unit_code'      => 'butir',
                'minimum_stock'       => 500,
            ],
            [
                'code'                => 'IK-004',
                'name'                => 'Ikan Tongkol',
                'description'         => 'Ikan tongkol segar beku.',
                'product_category_id' => $laukPauk,
                'base_unit_code'      => 'kg',
                'minimum_stock'       => 30,
            ],
            [
                'code'                => 'TM-005',
                'name'                => 'Tempe',
                'description'         => 'Tempe kedelai bungkus daun.',
                'product_category_id' => $laukPauk,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 100,
            ],
            // Sayur-sayuran
            [
                'code'                => 'SB-006',
                'name'                => 'Bayam Hijau',
                'description'         => 'Bayam segar, satu ikat.',
                'product_category_id' => $sayuran,
                'base_unit_code'      => 'ikat',
                'minimum_stock'       => 20,
            ],
            [
                'code'                => 'WT-007',
                'name'                => 'Wortel',
                'description'         => 'Wortel segar lokal.',
                'product_category_id' => $sayuran,
                'base_unit_code'      => 'kg',
                'minimum_stock'       => 25,
            ],
            // Buah-buahan
            [
                'code'                => 'PS-008',
                'name'                => 'Pisang Kepok',
                'description'         => 'Pisang lokal, satu buah.',
                'product_category_id' => $buahBuahan,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 150,
            ],
            // Minuman
            [
                'code'                => 'SU-009',
                'name'                => 'Susu UHT Coklat 200ml',
                'description'         => 'Susu UHT dalam kemasan kotak.',
                'product_category_id' => $minuman,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 50,
            ],
            [
                'code'                => 'AM-010',
                'name'                => 'Air Mineral Botol',
                'description'         => 'Air mineral dalam kemasan botol.',
                'product_category_id' => $minuman,
                'base_unit_code'      => 'pcs',
                'minimum_stock'       => 50,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Menambahkan multi-satuan (contoh)
        $productBeras = Product::where('code', 'BR-001')->first();

        $productTelur = Product::where('code', 'TL-003')->first();

        $productSusu = Product::where('code', 'SU-009')->first();

    }
}
