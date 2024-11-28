<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgressModel;
use App\Models\MahasiswaModel;

class PesanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Inbox Page',
            'list' => ['Home', 'Inbox']
        ];

        $activeMenu = 'index';

        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Mahasiswa tidak ditemukan');
        }

        $apply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas')
            ->get();

        $approval = ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas')
            ->get();

        return view('mahasiswa.inbox.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'apply' => $apply, 'approval' => $approval]);
    }
}
