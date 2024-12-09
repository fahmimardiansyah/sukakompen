<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TendikSeeder extends Seeder
{
    public function run(): void
    {
        $data =[
            'tendik_id' => 1,
            'user_id' => 3,
            'nip' => '54321098',
            'tendik_nama' => 'Hasan Basyri',
            'tendik_no_telp' => '08123456789',
            'tendik_email' => 'iykyknow09@gmail.com',
        ];

        DB::table('m_tendik')->insert($data);
    }
}
