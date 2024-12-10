<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkumulasiModel;
use App\Models\AlpaModel;
use App\Models\MahasiswaModel;

class AkumulasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Akumulasi',
            'list' => ['Home', 'Akumulasi']
        ];

        $activeMenu = 'akumulasi';

        $user = auth()->user();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()->route('dashboardmhs')->with('error', 'Mahasiswa tidak ditemukan');
        }

        $mahasiswaId = $mahasiswa->mahasiswa_id;

        $jumlahJamAlpa = AlpaModel::where('mahasiswa_alpa_nim', $mahasiswa->nim)->sum('jam_alpa');

        $akumulasi = AkumulasiModel::where('mahasiswa_id', $mahasiswaId)->get();

        foreach ($akumulasi as $item) {
            if ($item->semester == $mahasiswa->semester) {
                $item->update(['jumlah_alpa' => $jumlahJamAlpa]);
            }
        }

        return view('mahasiswa.akumulasi.index', [
            'akumulasi' => $akumulasi,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }

}