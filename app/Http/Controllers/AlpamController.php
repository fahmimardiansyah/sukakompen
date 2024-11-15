<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlpaModel;
use App\Models\ProgressModel;
use Laravel\Prompts\Progress;

class AlpamController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Alpa Mahasiswa Page',
            'list' => ['Home', 'Alpa Mahasiswa']
        ];
    
        $activeMenu = 'alpam';

        $mahasiswa = AlpaModel::all();

        $progress = ProgressModel::all();
        
        return view('alpam.index', ['mahasiswa' => $mahasiswa,'breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu, 'progress' => $progress]);
    }
}
