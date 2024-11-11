<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KompenmaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kompen Mahasiswa Page',
            'list' => ['Home', 'Kompen Mahasiswa']
        ];
    
        $activeMenu = 'kompenma';

        // Data Mahasiswa yang ingin ditampilkan di Blade
        $mahasiswa = [
            ['nama' => 'Fahmi Mardiansyah', 'NIM' => '2241760064', 'tugas_kompen' => 'UI/UX Design', 'bobot_kompen' => '10 jam', 'status' => 'Sedang Dikerjakan'],
            ['nama' => 'Hasan Basri', 'NIM' => '2241760064', 'tugas_kompen' => 'Membuat PPT', 'bobot_kompen' => '4 jam', 'status' => 'Selesai'],
            ['nama' => "Fa'iz Abiyu", 'NIM' => '2241760064', 'tugas_kompen' => 'Arsip Nilai', 'bobot_kompen' => '4 jam', 'status' => 'Sedang Dikerjakan'],
            ['nama' => 'Nasya Syafinka', 'NIM' => '2241760064', 'tugas_kompen' => 'Membuat PPT', 'bobot_kompen' => '4 jam', 'status' => 'Selesai'],
            ['nama' => 'Nabilah Rahmah', 'NIM' => '2241760064', 'tugas_kompen' => 'Rekap Absensi', 'bobot_kompen' => '5 jam', 'status' => 'Sedang Dikerjakan'],
            ['nama' => 'Adam Safrila', 'NIM' => '2241760064', 'tugas_kompen' => 'Membuat Poster', 'bobot_kompen' => '7 jam', 'status' => 'Selesai'],
        ];

        
        return view('kompenma.index', ['mahasiswa' => $mahasiswa,'breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu]);
    }
}
