<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'alpa_id' => 1,
                'mahasiswa_alpa_nim' => '2030456789',
                'mahasiswa_alpa_nama' => 'Faiz Abiyu',
                'jam_alpa' => 20,
            ],
        ];

        DB::table('m_mahasiswa_alpa')->insert($data);
    }
}