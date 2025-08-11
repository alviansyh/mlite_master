<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class DemoUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'code' => 'kg',
                'name' => 'Kilogram',
            ],
            [
                'code' => 'gr',
                'name' => 'Gram',
            ],
            [
                'code' => 'pcs',
                'name' => 'Pieces',
            ],
            [
                'code' => 'ikat',
                'name' => 'Ikat',
            ],
            [
                'code' => 'butir',
                'name' => 'Butir',
            ],
            [
                'code' => 'box',
                'name' => 'Box/Dus',
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
