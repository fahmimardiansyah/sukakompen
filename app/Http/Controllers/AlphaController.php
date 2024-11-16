<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlphaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Alpa Mahasiswa Page',
            'list' => ['Home', 'Alpa Mahasiswa']
        ];

        $activeMenu = 'alpha';

        // Data Mahasiswa yang ingin ditampilkan di Blade
        $mahasiswa = [
            ['nama' => 'Fahmi Mardiansyah', 'jam_kompen' => '4 jam', 'jumlah_alpa' => '14 jam'],
            ['nama' => 'Hasan Basri', 'jam_kompen' => '1 jam', 'jumlah_alpa' => '4 jam'],
            ['nama' => "Fa'iz Abiyu", 'jam_kompen' => '3 jam', 'jumlah_alpa' => '2 jam'],
            ['nama' => 'Nasya Syafinka', 'jam_kompen' => '4 jam', 'jumlah_alpa' => '8 jam'],
            ['nama' => 'Nabilah Rahmah', 'jam_kompen' => '2 jam', 'jumlah_alpa' => '12 jam'],
            ['nama' => 'Adam Safrila', 'jam_kompen' => '2 jam', 'jumlah_alpa' => '4 jam'],
        ];


        return view('alpha.index', ['mahasiswa' => $mahasiswa, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
