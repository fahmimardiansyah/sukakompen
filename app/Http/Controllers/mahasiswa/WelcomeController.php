<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TugasModel;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Page',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboardmhs';
        $tugas = TugasModel::with('jenis')->get();

        return view('mahasiswa.dashboardmhs', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'tugas' => $tugas,]);
    }
}
