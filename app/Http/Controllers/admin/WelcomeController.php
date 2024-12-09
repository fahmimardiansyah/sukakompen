<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AlpaModel;
use App\Models\ApprovalModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $breadcrumb = (object) [
            'title' => 'Dashboard Page',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'welcome';

        $tugas = TugasModel::where('user_id', $user->user_id)->get();

        $alpa = AlpaModel::with(['approval.tugas'])->count();

        $approval = ApprovalModel::with(['tugas', 'mahasiswa', 'progress'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->count();

        return view('admin.welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'tugas' => $tugas, 'alpa' => $alpa, 'approval' => $approval]);
    }
}
