<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkumulasiModel;

class APIAkumulasiController extends Controller
{
    public function index()
    {
        $akumulasi = AkumulasiModel::all();  // Contoh mengambil semua data akumulasi
        return response()->json($akumulasi);
    }

    public function show($mahasiswaId)
    {
        $akumulasi = AkumulasiModel::where('mahasiswa_id', $mahasiswaId)->get();
        return response()->json($akumulasi);
    }
}
