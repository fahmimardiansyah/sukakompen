<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'barang_id' => 1,
                'harga' => 6000000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 1,
                'barang_id' => 2,
                'harga' => 2500000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 1,
                'barang_id' => 3,
                'harga' => 150000,
                'jumlah' => 2
            ],
            [
                'penjualan_id' => 2,
                'barang_id' => 4,
                'harga' => 200000,
                'jumlah' => 3
            ],
            [
                'penjualan_id' => 2,
                'barang_id' => 5,
                'harga' => 15000,
                'jumlah' => 4
            ],
            [
                'penjualan_id' => 2,
                'barang_id' => 6,
                'harga' => 20000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 3,
                'barang_id' => 7,
                'harga' => 10000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 3,
                'barang_id' => 8,
                'harga' => 15000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 3,
                'barang_id' => 9,
                'harga' => 3500000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 4,
                'barang_id' => 10,
                'harga' => 1200000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 4,
                'barang_id' => 11,
                'harga' => 200000,
                'jumlah' => 3
            ],
            [
                'penjualan_id' => 4,
                'barang_id' => 12,
                'harga' => 75000,
                'jumlah' => 2
            ],
            [
                'penjualan_id' => 5,
                'barang_id' => 13,
                'harga' => 5000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 5,
                'barang_id' => 14,
                'harga' => 3000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 5,
                'barang_id' => 15,
                'harga' => 4000000,
                'jumlah' => 2
            ],
            [
                'penjualan_id' => 6,
                'barang_id' => 1,
                'harga' => 6000000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 6,
                'barang_id' => 2,
                'harga' => 2500000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 6,
                'barang_id' => 3,
                'harga' => 150000,
                'jumlah' => 2
            ],
            [
                'penjualan_id' => 7,
                'barang_id' => 4,
                'harga' => 200000,
                'jumlah' => 3
            ],
            [
                'penjualan_id' => 7,
                'barang_id' => 5,
                'harga' => 15000,
                'jumlah' => 4
            ],
            [
                'penjualan_id' => 7,
                'barang_id' => 6,
                'harga' => 20000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 8,
                'barang_id' => 7,
                'harga' => 10000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 8,
                'barang_id' => 8,
                'harga' => 15000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 8,
                'barang_id' => 9,
                'harga' => 3500000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 9,
                'barang_id' => 10,
                'harga' => 1200000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 9,
                'barang_id' => 11,
                'harga' => 200000,
                'jumlah' => 3
            ],
            [
                'penjualan_id' => 9,
                'barang_id' => 12,
                'harga' => 75000,
                'jumlah' => 2
            ],
            [
                'penjualan_id' => 10,
                'barang_id' => 13,
                'harga' => 5000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 10,
                'barang_id' => 14,
                'harga' => 3000,
                'jumlah' => 1
            ],
            [
                'penjualan_id' => 10,
                'barang_id' => 15,
                'harga' => 4000000,
                'jumlah' => 2
            ],
        ];
        DB::table('t_penjualan_detail')->insert($data);
    }
}
