<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;

class APIProfileMHSController extends Controller
{
    /**
     * Get all mahasiswa profiles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $mahasiswa = MahasiswaModel::with('user')->get(); // Mengambil semua data mahasiswa
        return response()->json($mahasiswa);
    }

    /**
     * Get profile of a specific mahasiswa.
     *
     * @param int $mahasiswaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($mahasiswaId)
    {
        $mahasiswa = MahasiswaModel::with('user')->where('mahasiswa_id', $mahasiswaId)->first(); // Mengambil mahasiswa spesifik berdasarkan ID

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa not found'
            ], 404);
        }

        return response()->json($mahasiswa);
    }
}
