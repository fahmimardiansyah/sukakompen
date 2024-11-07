<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Jenis Tugas Page',
            'list' => ['Home', 'Jenis Tugas']
        ];

        $activeMenu = 'jenis';

        return view('jenis.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
