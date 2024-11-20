<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $data =[
            'dosen_id' => 1,
            'user_id' => 2,
            'nidn' => '87654321',
            'dosen_nama' => 'Fahmi Mardiansyah',
            'dosen_no_telp' => '08123456789',
        ];

        DB::table('m_dosen')->insert($data);
    }
}
