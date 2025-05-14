<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use Illuminate\Support\Arr;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $produkList = [
            'kursi informa sieben',
            'meja informa wood',
            'sofa informa pillow',
            'lampu belajar'
        ];

        $colors = ['blue', 'red', 'yellow', 'green', 'black', 'white', 'grey', 'purple', 'orange'];

        foreach ($produkList as $produk) {
            for ($i = 1; $i <= 30; $i++) {
                $warna = Arr::random($colors);

                Inventory::create([
                    'name' => $produk . ' ' . $warna,
                    'identifier' => 'kursi',
                    'status' => 'available',
                    'description' => 'Stok untuk produk ' . $produk . ' warna ' . $warna,
                    'id_vendor' => 1,
                    'picture_1' => null,
                    'picture_2' => null,
                    'created_with' => 'seeder',
                    'updated_with' => 'seeder',
                ]);
            }
        }
    }
}
