<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KompetensiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kompetens Tugas Page',
            'list' => ['Home', 'Kompetensi Tugas']
        ];

        $activeMenu = 'kompetensi';

        return view('kompetensi.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
