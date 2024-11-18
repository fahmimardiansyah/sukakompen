<?php

namespace App\Http\Controllers\dosen_tendik;

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

        $activeMenu = 'notif';

        return view('dosen_tendik.notif.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
