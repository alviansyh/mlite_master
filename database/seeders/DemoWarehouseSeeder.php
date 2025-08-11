<?php
namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DemoWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $locations = [
            'DKI Jakarta' => [
                'Jakarta Pusat' => ['10110', '10120', '10130', '10140', '10150'],
                'Jakarta Utara' => ['14110', '14120', '14130', '14140', '14150'],
                'Jakarta Barat' => ['11110', '11120', '11130', '11140', '11150'],
                'Jakarta Selatan' => ['12110', '12120', '12130', '12140', '12150'],
                'Jakarta Timur' => ['13110', '13120', '13130', '13140', '13150'],
            ],
            'Jawa Barat' => [
                'Bandung' => ['40111', '40112', '40113', '40114', '40115'],
                'Bekasi' => ['17111', '17112', '17113', '17114', '17115'],
                'Depok' => ['16411', '16412', '16413', '16414', '16415'],
                'Bogor' => ['16111', '16112', '16113', '16114', '16115'],
            ],
            'Jawa Tengah' => [
                'Semarang' => ['50111', '50112', '50113', '50114', '50115'],
                'Surakarta' => ['57111', '57112', '57113', '57114', '57115'],
                'Yogyakarta' => ['55111', '55112', '55113', '55114', '55115'],
            ],
            'Jawa Timur' => [
                'Surabaya' => ['60111', '60112', '60113', '60114', '60115'],
                'Malang' => ['65111', '65112', '65113', '65114', '65115'],
            ],
            'Sumatera Utara' => [
                'Medan' => ['20111', '20112', '20113', '20114', '20115'],
            ],
            'Sulawesi Selatan' => [
                'Makassar' => ['90111', '90112', '90113', '90114', '90115'],
            ],
        ];

        for ($i = 0; $i < 50; $i++) {
            $randomState = array_rand($locations);
            $randomCity = array_rand($locations[$randomState]);
            $randomPostcode = $faker->randomElement($locations[$randomState][$randomCity]);

            Warehouse::create([
                'code' => 'WH-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'name' => 'Gudang ' . $faker->words(2, true),
                'state' => $randomState,
                'city' => $randomCity,
                'postcode' => $randomPostcode,
                'address' => $faker->address,
                'is_active' => $faker->boolean(90) // 90% kemungkinan aktif
            ]);
        }
    }
}
