<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApprovalModel;
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

        $user = auth()->user();

        $approval = ApprovalModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();

        $progress = ProgressModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();

        $approvalAll = ApprovalModel::with(['tugas', 'mahasiswa'])
            ->get();

        $progressAll = ProgressModel::with(['tugas', 'mahasiswa'])
            ->get();

        return view('admin.kompenma.index', [
            'mahasiswa' => $approval,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'progress' => $progress,
            'approvalAll' => $approvalAll,
            'progressAll' => $progressAll
        ]);
    }
}