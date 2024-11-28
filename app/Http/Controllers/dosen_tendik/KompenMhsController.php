<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApprovalModel;

class KompenMhsController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kompen Mahasiswa Page',
            'list' => ['Home', 'Kompen Mahasiswa']
        ];
    
        $activeMenu = 'kompenmhs';

        $user = auth()->user();

        $approval = ApprovalModel::with(['tugas', 'mahasiswa', 'progress'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();

        return view('dosen_tendik.kompenmhs.index', [
            'mahasiswa' => $approval,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }
}
