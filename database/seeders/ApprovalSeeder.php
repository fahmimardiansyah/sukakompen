<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'approval_id' => 1,
                'progress_id' => 1,
                'mahasiswa_id' => 1,
                'tugas_id' => 2,
                'status' => null,
            ],
        ];

        DB::table('t_approval_tugas')->insert($data);
    }
}
