<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkumulasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Akumulasi',
            'list' => ['Home', 'Akumulasi']
        ];
    
        $activeMenu = 'akumulasi';

        // Data Akumulasi Mahasiswa yang ingin ditampilkan di Blade
        $mahasiswa = [
            ['semester' => 'Semester 1', 'jumlah_alpa' => '2'],
            ['semester' => 'Semester 2', 'jumlah_alpa' => '4'],
            ['semester' => 'Semester 3', 'jumlah_alpa' => '1'],
            ['semester' => 'Semester 4', 'jumlah_alpa' => '3'],
            ['semester' => 'Semester 5', 'jumlah_alpa' => '5'],
            ['semester' => 'Semester 6', 'jumlah_alpa' => '0'],
        ];

        return view('akumulasi.index', ['mahasiswa' => $mahasiswa, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}