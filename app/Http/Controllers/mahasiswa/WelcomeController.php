<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AkumulasiModel;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use App\Models\ProgressModel;
use Illuminate\Http\Request;
use App\Models\TugasModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\progress;

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
        
        $progress = ProgressModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->whereIn('tugas_id', TugasModel::all()->pluck('tugas_id'))
            ->whereNotIn('tugas_id', ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->get();

        $total = AkumulasiModel::where('semester', $mahasiswa->semester)->first();

        return view('mahasiswa.dashboardmhs', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'tugas' => $tugas, 'progress' => $progress, 'alpa' => $mahasiswa, 'total' => $total]);
    }
}
