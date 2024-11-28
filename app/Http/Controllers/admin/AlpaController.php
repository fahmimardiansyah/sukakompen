<?php

namespace App\Http\Controllers\admin;

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

        $activeMenu = 'alpam';

        $mahasiswa = AlpaModel::with(['approval.tugas'])->get();

        return view('admin.alpam.index', [
            'mahasiswa' => $mahasiswa,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }
}
