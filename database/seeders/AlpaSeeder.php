<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'alpa_id' => 1,
                'mahasiswa_alpa_nim' => '2030456789',
                'mahasiswa_alpa_nama' => 'Amelia Andani',
                'progress_id' => 1,
                'jam_alpa' => 3,
            ],
            [
                'alpa_id' => 2,
                'mahasiswa_alpa_nim' => '2030456790',
                'mahasiswa_alpa_nama' => 'Rehan Hisyam',
                'progress_id' => 2,
                'jam_alpa' => 4,
            ],
            [
                'alpa_id' => 3,
                'mahasiswa_alpa_nim' => '2030456791',
                'mahasiswa_alpa_nama' => 'Faiz Abiyu ',
                'progress_id' => 3,
                'jam_alpa' => 2,
            ],
            [
                'alpa_id' => 4,
                'mahasiswa_alpa_nim' => '2030456792',
                'mahasiswa_alpa_nama' => 'Fahmi Mardiansyah',
                'progress_id' => 1,
                'jam_alpa' => 1,
            ],
            [
                'alpa_id' => 5,
                'mahasiswa_alpa_nim' => '2030456793',
                'mahasiswa_alpa_nama' => 'Hasan Basri',
                'progress_id' => 4,
                'jam_alpa' => 5,
            ],
            [
                'alpa_id' => 6,
                'mahasiswa_alpa_nim' => '2030456794',
                'mahasiswa_alpa_nama' => 'Nasywa Syafinka',
                'progress_id' => 2,
                'jam_alpa' => 3,
            ],
            [
                'alpa_id' => 7,
                'mahasiswa_alpa_nim' => '2030456795',
                'mahasiswa_alpa_nama' => 'Renald Ramadhan',
                'progress_id' => 3,
                'jam_alpa' => 2,
            ],
            [
                'alpa_id' => 8,
                'mahasiswa_alpa_nim' => '2030456796',
                'mahasiswa_alpa_nama' => 'Susi Susanti',
                'progress_id' => 4,
                'jam_alpa' => 4,
            ],
            [
                'alpa_id' => 9,
                'mahasiswa_alpa_nim' => '2030456797',
                'mahasiswa_alpa_nama' => 'Nabilah Rahmah',
                'progress_id' => 1,
                'jam_alpa' => 6,
            ],
            [
                'alpa_id' => 10,
                'mahasiswa_alpa_nim' => '2030456798',
                'mahasiswa_alpa_nama' => 'Merry Riana',
                'progress_id' => 2,
                'jam_alpa' => 3,
            ],
        ];

        DB::table('m_mahasiswa_alpa')->insert($data);
    }
}