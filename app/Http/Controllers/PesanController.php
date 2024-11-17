<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pesan Page',
            'list' => ['Home', 'Pesan Tugas']
        ];

        $activeMenu = 'pesan';

        return view('pesan.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
