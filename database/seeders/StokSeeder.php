<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'stok_id' => 1,
                'barang_id' => 1,
                'supplier_id' => 1,
                'user_id' => 1,
                'stok_tanggal'=> '2024-09-01 12:00:00',
                'stok_jumlah'=> 50,
            ],
            [
                'stok_id' => 2,
                'barang_id' => 2,
                'supplier_id' => 1,
                'user_id' => 2,
                'stok_tanggal'=> '2024-09-02 14:00:00',
                'stok_jumlah'=> 30,
            ],
            [
                'stok_id' => 3,
                'barang_id' => 3,
                'supplier_id' => 1,
                'user_id' => 3,
                'stok_tanggal'=> '2024-09-03 09:00:00',
                'stok_jumlah'=> 40,
            ],
            [
                'stok_id' => 4,
                'barang_id' => 4,
                'supplier_id' => 2,
                'user_id' => 1,
                'stok_tanggal'=> '2024-09-04 08:30:00',
                'stok_jumlah'=> 60,
            ],
            [
                'stok_id' => 5,
                'barang_id' => 5,
                'supplier_id' => 3,
                'user_id' => 2,
                'stok_tanggal'=> '2024-09-05 10:15:00',
                'stok_jumlah'=> 100,
            ],
            [
                'stok_id' => 6,
                'barang_id' => 6,
                'supplier_id' => 3,
                'user_id' => 3,
                'stok_tanggal'=> '2024-09-06 13:45:00',
                'stok_jumlah'=> 90,
            ],
            [
                'stok_id' => 7,
                'barang_id' => 7,
                'supplier_id' => 3,
                'user_id' => 1,
                'stok_tanggal'=> '2024-09-07 11:20:00',
                'stok_jumlah'=> 25,
            ],
            [
                'stok_id' => 8,
                'barang_id' => 8,
                'supplier_id' => 2,
                'user_id' => 2,
                'stok_tanggal'=> '2024-09-08 15:00:00',
                'stok_jumlah'=> 35,
            ],
            [
                'stok_id' => 9,
                'barang_id' => 9,
                'supplier_id' => 2,
                'user_id' => 3,
                'stok_tanggal'=> '2024-09-09 09:45:00',
                'stok_jumlah'=> 45,
            ],
            [
                'stok_id' => 10,
                'barang_id' => 10,
                'supplier_id' => 1,
                'user_id' => 1,
                'stok_tanggal'=> '2024-09-10 12:30:00',
                'stok_jumlah'=> 20,
            ],
            [
                'stok_id' => 11,
                'barang_id' => 11,
                'supplier_id' => 1,
                'user_id' => 2,
                'stok_tanggal'=> '2024-09-11 14:00:00',
                'stok_jumlah'=> 55,
            ],
            [
                'stok_id' => 12,
                'barang_id' => 12,
                'supplier_id' => 2,
                'user_id' => 3,
                'stok_tanggal'=> '2024-09-12 16:30:00',
                'stok_jumlah'=> 25,
            ],
            [
                'stok_id' => 13,
                'barang_id' => 13,
                'supplier_id' => 3,
                'user_id' => 1,
                'stok_tanggal'=> '2024-09-13 11:00:00',
                'stok_jumlah'=> 40,
            ],
            [
                'stok_id' => 14,
                'barang_id' => 14,
                'supplier_id' => 3,
                'user_id' => 2,
                'stok_tanggal'=> '2024-09-14 14:30:00',
                'stok_jumlah'=> 70,
            ],
            [
                'stok_id' => 15,
                'barang_id' => 15,
                'supplier_id' => 2,
                'user_id' => 3,
                'stok_tanggal'=> '2024-09-15 12:00:00',
                'stok_jumlah'=> 50,
            ],
            ];
            DB::table('t_stok')->insert($data);
    }
}
