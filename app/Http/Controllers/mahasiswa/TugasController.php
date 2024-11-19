<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\TugasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Tugas Page',
            'list' => ['Home', 'Tugas']
        ];

        $activeMenu = 'kompen';

        $tugas = TugasModel::with('jenis')->get();

        return view('mahasiswa.task.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'tugas' => $tugas,
        ]);
    }

    public function show()
    {
        $breadcrumb = (object) [
            'title' => 'Tugas Page',
            'list' => ['Home', 'Tugas', 'detail']
        ];

        return view('mahasiswa.task.detail', ['breadcrumb' => $breadcrumb]);
    }
}
