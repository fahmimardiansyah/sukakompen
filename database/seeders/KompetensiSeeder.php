<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kompetensi_id' => 1, 
                'kompetensi_kode' => 'BED', 
                'kompetensi_nama' => 'Backend Developer', 
                'kompetensi_deskripsi' => 'Memiliki kemampuan untuk menggunakan bahasa pemrograman (Java, Phyton, Node.js, Flutter, JavaScript, dan PHP)'
            ],
            [
                'kompetensi_id' => 2, 
                'kompetensi_kode' => 'FED', 
                'kompetensi_nama' => 'Frontend Developer', 
                'kompetensi_deskripsi' => 'Memiliki kemampuan untuk mengolah tampilan aplikasi dengan kompetensi dalam penggunaan HTML, CSS, JavaScript, dan framework front end (React, Vue, atau Angular)'
            ],
            [
                'kompetensi_id' => 3, 
                'kompetensi_kode' => 'DBA', 
                'kompetensi_nama' => 'Database Administrator', 
                'kompetensi_deskripsi' => 'Memiliki kemampuan untuk mengelola database dengan kompetensi berupa SQL, indexing, keamanan data, back up dan recovery data'
            ],
            [
                'kompetensi_id' => 4, 
                'kompetensi_kode' => 'NWE', 
                'kompetensi_nama' => 'Network Engineer', 
                'kompetensi_deskripsi' => 'Memiliki kemampuan untuk menangani pengaturan dan keamanan jaringan dengan kompetensi berupa konfigurasi jaringan (LAN/WAN), firewall, VPN, keamanan jaringan, troubleshooting'
            ],
            [
                'kompetensi_id' => 5, 
                'kompetensi_kode' => 'DTE', 
                'kompetensi_nama' => 'Data Entry', 
                'kompetensi_deskripsi' => 'Melakukan rekap dokumen dengan kompetensi berupa kemampuan dalam pengoperasian  microsoft excel, microsoft word, serta manajemen dokumen'
            ],
            [
                'kompetensi_id' => 6, 
                'kompetensi_kode' => 'ITS', 
                'kompetensi_nama' => 'IT Support', 
                'kompetensi_deskripsi' => 'Menyediakan dukungan teknis langsung kepada pengguna yang membutuhkan bantuan teknologi dengan kemampuan berupa pengetahuan perangkat keras/lunak, public speaking'
            ],
            [
                'kompetensi_id' => 7, 
                'kompetensi_kode' => 'CTC', 
                'kompetensi_nama' => 'Content Creator', 
                'kompetensi_deskripsi' => 'Membuat materi edukasi baik video, infografis, atau modul pelatihan dengan kompetensi berupa desain grafis, pembuatan video, penggunaan software (Canva, Adobe studio)'
            ],
            [
                'kompetensi_id' => 8, 
                'kompetensi_kode' => 'TET', 
                'kompetensi_nama' => 'Technology Trainer', 
                'kompetensi_deskripsi' => 'Memberi pelatihan teknologi pada pengguna atau komunitas dengan kompetensi berupa penguasaan teknologi yang dibutuhkan, kemampuan menyusun materi, kemampuan berkomunikasi'
            ],
            [
                'kompetensi_id' => 9, 
                'kompetensi_kode' => 'DTA', 
                'kompetensi_nama' => 'Data Analyst', 
                'kompetensi_deskripsi' => 'Menganalisis data untuk laporan penelitian, dengan keahlian dalam analisis, statistik dasar, dan visualisasi data'
            ],
            [
                'kompetensi_id' => 10, 
                'kompetensi_kode' => 'DTS', 
                'kompetensi_nama' => 'Data Scientist', 
                'kompetensi_deskripsi' => 'Menggunakan machine learning dan analisis lanjutan, dengan kompetensi dalam pengolahan data besar dan alat seperti TensorFlow'
            ],
            [
                'kompetensi_id' => 11, 
                'kompetensi_kode' => 'RCO', 
                'kompetensi_nama' => 'Research Coordinator', 
                'kompetensi_deskripsi' => 'Mengatur penelitian dan dokumentasi hasil, dengan kemampuan manajemen proyek, dokumentasi, dan komunikasi tim'
            ],
            [
                'kompetensi_id' => 12, 
                'kompetensi_kode' => 'TEW', 
                'kompetensi_nama' => 'Technical Writer', 
                'kompetensi_deskripsi' => 'Mendokumentasikan hasil penelitian, dengan keahlian penulisan ilmiah, tata bahasa, dan standar publikasi'
            ],
            [
                'kompetensi_id' => 13, 
                'kompetensi_kode' => 'UXR', 
                'kompetensi_nama' => 'UX Researcher', 
                'kompetensi_deskripsi' => 'Melakukan riset pengalaman pengguna, dengan keterampilan dalam UX research, wawancara pengguna, dan alat UX (misalnya Figma)'
            ]
        ];
        DB::table('t_kompetensi')->insert($data);
    }
}
