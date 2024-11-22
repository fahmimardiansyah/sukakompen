<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class APIDashboardMHSController extends Controller
{
    /**
     * Display a listing of all Mahasiswa and Tugas.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Ambil semua data Mahasiswa dan Tugas
        $mahasiswa = MahasiswaModel::all();
        $tugas = TugasModel::all();

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'tugas' => $tugas,
        ]);
    }

    /**
     * Display specific Mahasiswa and their Tugas by Mahasiswa ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        // Validasi input
        $request->validate([
            'mahasiswa_id' => 'required|integer',
        ]);

        $mahasiswaId = $request->mahasiswa_id;

        // Ambil data Mahasiswa berdasarkan ID
        $mahasiswa = MahasiswaModel::find($mahasiswaId);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa not found'], 404);
        }

        // Ambil data Tugas yang berkaitan dengan Mahasiswa (jika ada hubungan)
        $tugas = TugasModel::where('user_id', $mahasiswa->user_id)->get();

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'tugas' => $tugas,
        ]);
    }
}
