<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiMhsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kompetensi_mahasiswa_id' => 1,
                'mahasiswa_id' => 1,
                'kompetensi_id' => 1,
            ],
            [
                'kompetensi_mahasiswa_id' => 2,
                'mahasiswa_id' => 1,
                'kompetensi_id' => 2,
            ],
            [
                'kompetensi_mahasiswa_id' => 3,
                'mahasiswa_id' => 1,
                'kompetensi_id' => 3,
            ],
        ];

        DB::table('t_kompetensi_mahasiswa')->insert($data);
    }
}
