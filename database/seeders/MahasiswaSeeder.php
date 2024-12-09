<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'mahasiswa_id' => 1,
                'user_id'=> 4,
                'nim'=> '2030456789',
                'mahasiswa_nama'=> 'Faiz Abiyu',
                'jumlah_alpa'=> 20,
                'prodi_id'=> 2,
                'semester'=> 5,
            ],
        ];
        DB::table('m_mahasiswa')->insert($data);
    }
}
