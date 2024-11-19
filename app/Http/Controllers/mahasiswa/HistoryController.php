<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProgressModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Histori Tugas',
            'list' => ['Home', 'Histori']
        ];
        
        $activeMenu = 'history';

        $user = auth()->user();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()->url('dashboardmhs')->with('error', 'Mahasiswa tidak ditemukan');
        }

        $mahasiswaId = $mahasiswa->mahasiswa_id;

        $history = ProgressModel::where('mahasiswa_id', $mahasiswaId)
                ->with('tugas')->get();

        return view('mahasiswa.history.index', ['history' => $history, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
