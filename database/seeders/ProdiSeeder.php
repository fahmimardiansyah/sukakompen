<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['prodi_id' =>1, 'prodi_kode' => 'TI', 'prodi_nama' => 'Teknologi Informasi'],
            ['prodi_id' =>2, 'prodi_kode' => 'SIB', 'prodi_nama' => 'Sistem Informasi Bisnis'],
            ['prodi_id' =>3, 'prodi_kode' => 'PPLS', 'prodi_nama' => 'Pengembangan Perangkat Lunak Situs'],
        ];
        DB::table('m_prodi')->insert($data);
    }
}
