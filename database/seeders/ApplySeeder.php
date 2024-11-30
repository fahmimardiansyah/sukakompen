<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'mahasiswa_id' => 1,
                'tugas_id' => 2,
                'apply_status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('t_apply')->insert($data);
    }
}