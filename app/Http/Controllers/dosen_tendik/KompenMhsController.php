<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressModel;

class KompenMhsController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kompen Mahasiswa Page',
            'list' => ['Home', 'Kompen Mahasiswa']
        ];
    
        $activeMenu = 'kompenmhs';

        $mahasiswa = ProgressModel::with(['tugas', 'mahasiswa'])->get();
        
        return view('dosen_tendik.kompenmhs.index', ['mahasiswa' => $mahasiswa,'breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu]);
    }
}
