<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Histori Tugas',
            'list' => ['Home', 'Histori']
        ];
        
        $activeMenu = 'history';

        // Data Tugas Mahasiswa yang ingin ditampilkan di Blade
        $mahasiswa = [
            ['tugas' => 'Fisika', 'status' => 'Selesai', 'form_kompen' => 'Form A'],
            ['tugas' => 'Matematika', 'status' => 'Belum Selesai', 'form_kompen' => 'Form B'],
            ['tugas' => 'Kimia', 'status' => 'Selesai', 'form_kompen' => 'Form A'],
            ['tugas' => 'Biologi', 'status' => 'Selesai', 'form_kompen' => 'Form C'],
            ['tugas' => 'Sejarah', 'status' => 'Belum Selesai', 'form_kompen' => 'Form B'],
        ];

        return view('history.index', ['mahasiswa' => $mahasiswa, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}