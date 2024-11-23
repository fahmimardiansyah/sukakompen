<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'progress_id' => 1,
                'apply_id' => 1,
                'mahasiswa_id' => 1,
                'tugas_id' => 2,
                'status' => true,
            ],
        ];

        DB::table('t_progress')->insert($data);
    }
}
