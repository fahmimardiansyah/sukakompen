<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode'=> 'BAR001',
                'barang_nama'=> 'Laptop',
                'harga_beli'=> 5000000,
                'harga_jual'=> 6000000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode'=> 'BAR002',
                'barang_nama'=> 'Smartphone',
                'harga_beli'=> 2000000,
                'harga_jual'=> 2500000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode'=> 'BAR003',
                'barang_nama'=> 'Jaket',
                'harga_beli'=> 100000,
                'harga_jual'=> 150000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode'=> 'BAR004',
                'barang_nama'=> 'Sepatu',
                'harga_beli'=> 150000,
                'harga_jual'=> 200000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode'=> 'BAR005',
                'barang_nama'=> 'Roti',
                'harga_beli'=> 10000,
                'harga_jual'=> 15000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode'=> 'BAR006',
                'barang_nama'=> 'Nasi Goreng',
                'harga_beli'=> 15000,
                'harga_jual'=> 20000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode'=> 'BAR007',
                'barang_nama'=> 'Kopi Hitam',
                'harga_beli'=> 5000,
                'harga_jual'=> 10000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode'=> 'BAR008',
                'barang_nama'=> 'Jus Jeruk',
                'harga_beli'=> 10000,
                'harga_jual'=> 15000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode'=> 'BAR009',
                'barang_nama'=> 'Sofa',
                'harga_beli'=> 3000000,
                'harga_jual'=> 3500000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode'=> 'BAR0010',
                'barang_nama'=> 'Meja Kayu',
                'harga_beli'=> 1000000,
                'harga_jual'=> 1200000,
            ],
            [
                'barang_id' => 11,
                'kategori_id' => 1,
                'barang_kode'=> 'BAR0011',
                'barang_nama'=> 'Mouse',
                'harga_beli'=> 150000,
                'harga_jual'=> 200000,
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 2,
                'barang_kode'=> 'BAR0012',
                'barang_nama'=> 'Kaos',
                'harga_beli'=> 50000,
                'harga_jual'=> 75000,
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 3,
                'barang_kode'=> 'BAR0013',
                'barang_nama'=> 'Indomie',
                'harga_beli'=> 2500,
                'harga_jual'=> 5000,
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 4,
                'barang_kode'=> 'BAR0014',
                'barang_nama'=> 'Es Teh Manis',
                'harga_beli'=> 2500,
                'harga_jual'=> 3000,
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 5,
                'barang_kode'=> 'BAR0015',
                'barang_nama'=> 'Lemari',
                'harga_beli'=> 2000000,
                'harga_jual'=> 4000000,
            ],
            ];
            DB::table('m_barang')->insert($data);
    }
}
