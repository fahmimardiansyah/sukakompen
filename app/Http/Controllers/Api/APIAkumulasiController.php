<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use App\Models\AkumulasiModel;
use Illuminate\Http\Request;

class APIAkumulasiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $akumulasi = AkumulasiModel::all();

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'akumulasi' => $akumulasi,
        ]);
    }
}