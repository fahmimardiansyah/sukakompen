<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pesan Page',
            'list' => ['Home', 'Pesan Tugas']
        ];

        $activeMenu = 'pesan';

        return view('admin.pesan.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function apply()
    {
        return view('admin.pesan.show_ajax');
    }

    public function tugas()
    {
        return view('admin.pesan.acc_ajax');
    }
}
