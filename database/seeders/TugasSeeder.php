<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tugas_id' => 1,
                'user_id' => 1,
                'tugas_No' => 'fdf76b9e-3926-4d9e-a53e-aabb55f6cfd5',
                'tugas_nama' => 'Rekap Absen',
                'jenis_id' => 3,
                'tugas_tipe' => 'online',
                'tugas_deskripsi' => 'Melakukan rekap absensi mahasiswa semester 2 pada bulan November 2024',
                'tugas_kuota' => 2,
                'tugas_jam_kompen' => 4,
                'tugas_tenggat' => '2024-11-07 23:59:00',
            ],
            [
                'tugas_id' => 2,
                'user_id' => 2,
                'tugas_No' => 'f1d6c691-f72e-4717-975a-f0ebc4741a8f',
                'tugas_nama' => 'Membuat website untuk sistem manage data siswa',
                'jenis_id' => 3,
                'tugas_tipe' => 'online',
                'tugas_deskripsi' => 'Membuat kodingan backend untuk sebuah data siswa di SD Sabilillah',
                'tugas_kuota' => 4,
                'tugas_jam_kompen' => 8,
                'tugas_tenggat' => '2024-11-15 23:59:00',
            ],
            [
                'tugas_id' => 3,
                'user_id' => 3,
                'tugas_No' => 'fbe202c0-1609-4fd0-8d2b-684d782e250c',
                'tugas_nama' => 'Analisis cara kerja ez-parky untuk penelitian dosen',
                'jenis_id' => 1,
                'tugas_tipe' => 'online',
                'tugas_deskripsi' => 'Melakukan analisis untuk bahan penelitian bersama dosen tentang simulasi sistem ez-parky',
                'tugas_kuota' => 3,
                'tugas_jam_kompen' => 12,
                'tugas_tenggat' => '2024-11-17 23:59:00',
            ],
        ];
        DB::table('t_tugas')->insert($data);

    }
}
