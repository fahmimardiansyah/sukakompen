<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jenis_id' =>1, 
                'jenis_kode' => 'PNL', 
                'jenis_nama' => 'Penelitian', 
                'jenis_deskripsi' => 'Jenis tugas yang berkaitan dengan keterampilan teknis spesifik yang dimiliki mahasiswa'
            ],
            [
                'jenis_id' =>2, 
                'jenis_kode' => 'PGB', 
                'jenis_nama' => 'Pengabdian', 
                'jenis_deskripsi' => 'Jenis tugas yang berfokus pada interaksi sosial untuk membantu edukasi masyarakat'
            ],
            [
                'jenis_id' =>3, 
                'jenis_kode' => 'TKS', 
                'jenis_nama' => 'Teknis', 
                'jenis_deskripsi' => 'Jenis tugas yang fokus pada analisis data dalam penelitian dosen untuk meningkatkan pengembangan wawasan'
                ]
        ];
        DB::table('m_jenis')->insert($data);
    }
}
