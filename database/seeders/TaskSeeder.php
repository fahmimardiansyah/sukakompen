<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Gunakan DB facade untuk penyisipan data
use App\Models\TaskModel; // Pastikan ini sesuai dengan nama model yang benar

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task = [
            [
                'title' => 'Arsip Absensi',
                'description' => 'Mengarsip ketidakhadiran dalam satu jam untuk menghindari denda di satu jurusan.',
                'category' => 'Teknis',
                'image' => 'img/card.png',
            ],
            [
                'title' => 'Pengarsipan Laporan',
                'description' => 'Mengarsip laporan bulanan untuk kebutuhan akreditasi.',
                'category' => 'Administratif',
                'image' => 'img/card.png',
            ],
            [
                'title' => 'Pengumpulan Data Penelitian',
                'description' => 'Mengumpulkan data hasil penelitian terbaru dari setiap program studi.',
                'category' => 'Penelitian',
                'image' => 'img/card.png',
            ],
            // Tambahkan data tugas lainnya jika diperlukan
        ];

        // Menggunakan DB facade untuk menyisipkan data
        DB::table('task')->insert($task);
    }
}
