<?php

namespace App\Http\Controllers\dosen_tendik;

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
    
        $activeMenu = 'kompenmhs';

        $user = auth()->user();

        $mahasiswa = ProgressModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();

        return view('dosen_tendik.kompenmhs.index', [
            'mahasiswa' => $mahasiswa,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }
}
