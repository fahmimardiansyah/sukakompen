<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\ProgressModel;
use Illuminate\Http\Request;
use App\Models\TugasModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Page',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboardmhs';

        $user = Auth::user();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        $tugas = TugasModel::with('jenis')
            ->whereNotIn('tugas_id', ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->get();

        return view('mahasiswa.dashboardmhs', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'tugas' => $tugas]);
    }
}
