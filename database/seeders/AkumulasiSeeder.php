<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AkumulasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'akumulasi_id' => 1,
                'mahasiswa_id' => 1,
                'semester' => 1,
                'jumlah_alpa' => 4
            ],
            [
                'akumulasi_id' => 2,
                'mahasiswa_id' => 1,
                'semester' => 2,
                'jumlah_alpa' => 6
            ],
            [
                'akumulasi_id' => 3,
                'mahasiswa_id' => 1,
                'semester' => 3,
                'jumlah_alpa' => 8
            ],
            [
                'akumulasi_id' => 4,
                'mahasiswa_id' => 1,
                'semester' => 4,
                'jumlah_alpa' => 0
            ],
            [
                'akumulasi_id' => 5,
                'mahasiswa_id' => 1,
                'semester' => 5,
                'jumlah_alpa' => 4
            ],
            [
                'akumulasi_id' => 6,
                'mahasiswa_id' => 1,
                'semester' => 6,
                'jumlah_alpa' => 0
            ],
            [
                'akumulasi_id' => 7,
                'mahasiswa_id' => 1,
                'semester' => 7,
                'jumlah_alpa' => 0
            ],
            [
                'akumulasi_id' => 8,
                'mahasiswa_id' => 1,
                'semester' => 8,
                'jumlah_alpa' => 0
            ],
        ];

        DB::table('t_akumulasi')->insert($data);
    }
}
