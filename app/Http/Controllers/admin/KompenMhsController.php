<?php

namespace App\Http\Controllers\admin;

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
    
        $activeMenu = 'kompenma';

        $mahasiswa = ProgressModel::with(['tugas', 'mahasiswa'])->get();
        
        return view('admin.kompenma.index', ['mahasiswa' => $mahasiswa,'breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu]);
    }
}
