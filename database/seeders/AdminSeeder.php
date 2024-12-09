<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            'admin_id' => 1,
            'user_id' => 1,
            'nip' => '234567',
            'admin_nama' => 'Ian',
            'admin_no_telp' => '08123458675',
            'admin_email' => 'faizabiyu93@gmail.com',
        ];

        DB::table('m_admin')->insert($data);
    }
}
