<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AkumulasiModel;
use App\Models\AlpaModel;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use App\Models\ProgressModel;
use Illuminate\Http\Request;
use App\Models\TugasModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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

        $currentDate = Carbon::now();

        $tugas = TugasModel::with('jenis')
            ->whereNotIn('tugas_id', ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->where('tugas_tenggat', '>=', $currentDate)
            ->get();
        
        $progress = ProgressModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->whereIn('tugas_id', TugasModel::all()->pluck('tugas_id'))
            ->whereNotIn('tugas_id', ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->get();

        $progressCounts = ProgressModel::whereIn('tugas_id', $tugas->pluck('tugas_id'))
            ->groupBy('tugas_id')
            ->selectRaw('tugas_id, count(*) as progress_count')
            ->get()
            ->keyBy('tugas_id');

        $tampil = $tugas->filter(function($task) use ($progressCounts) {
            $progressCount = $progressCounts->get($task->tugas_id)->progress_count ?? 0;
            return $task->tugas_kuota > $progressCount; 
        });

        $total = AlpaModel::where('mahasiswa_alpa_nim', $mahasiswa->nim)->first();

        return view('mahasiswa.dashboardmhs', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'tugas' => $tampil, 'progress' => $progress, 'alpa' => $mahasiswa, 'total' => $total]);
    }
}
