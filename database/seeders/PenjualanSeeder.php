<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'John Doe',
                'penjualan_kode' => 'TRX001',
                'penjualan_tanggal' => '2024-09-01 12:30:00',
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 2,
                'pembeli' => 'Jane Smith',
                'penjualan_kode' => 'TRX002',
                'penjualan_tanggal' => '2024-09-02 14:00:00',
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Michael Brown',
                'penjualan_kode' => 'TRX003',
                'penjualan_tanggal' => '2024-09-03 09:30:00',
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 1,
                'pembeli' => 'Lisa Black',
                'penjualan_kode' => 'TRX004',
                'penjualan_tanggal' => '2024-09-04 10:00:00',
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'Paul White',
                'penjualan_kode' => 'TRX005',
                'penjualan_tanggal' => '2024-09-05 13:45:00',
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Emily Davis',
                'penjualan_kode' => 'TRX006',
                'penjualan_tanggal' => '2024-09-06 11:00:00',
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Mark Lee',
                'penjualan_kode' => 'TRX007',
                'penjualan_tanggal' => '2024-09-07 12:15:00',
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'Sarah Wilson',
                'penjualan_kode' => 'TRX008',
                'penjualan_tanggal' => '2024-09-08 16:30:00',
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'James Anderson',
                'penjualan_kode' => 'TRX009',
                'penjualan_tanggal' => '2024-09-09 14:00:00',
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'Samantha Martinez',
                'penjualan_kode' => 'TRX010',
                'penjualan_tanggal' => '2024-09-10 10:45:00',
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
