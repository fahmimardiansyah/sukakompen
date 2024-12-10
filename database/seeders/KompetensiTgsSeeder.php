<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiTgsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kompetensi_tugas_id' => 1,
                'tugas_id' => 1,
                'kompetensi_id' => 1,
            ],
            [
                'kompetensi_tugas_id' => 2,
                'tugas_id' => 1,
                'kompetensi_id' => 2,
            ],
            [
                'kompetensi_tugas_id' => 3,
                'tugas_id' => 1,
                'kompetensi_id' => 3,
            ],
            [
                'kompetensi_tugas_id' => 4,
                'tugas_id' => 2,
                'kompetensi_id' => 1,
            ],
            [
                'kompetensi_tugas_id' => 5,
                'tugas_id' => 3,
                'kompetensi_id' => 1,
            ],
            [
                'kompetensi_tugas_id' => 6,
                'tugas_id' => 3,
                'kompetensi_id' => 2,
            ],
        ];

        DB::table('t_kompetensi_tugas')->insert($data);
    }
}
