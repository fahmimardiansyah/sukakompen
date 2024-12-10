<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlpaModel;

class AlpaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Alpa Mahasiswa Page',
            'list' => ['Home', 'Alpa Mahasiswa']
        ];

        $activeMenu = 'alpha';

        $mahasiswa = AlpaModel::all();

        return view('dosen_tendik.alpha.index', [
            'mahasiswa' => $mahasiswa,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }
}
