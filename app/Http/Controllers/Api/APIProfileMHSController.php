<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;

class APIProfileMHSController extends Controller
{
    // Mengambil data profil mahasiswa berdasarkan data yang dikirimkan
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

        // Kembalikan data profil mahasiswa
        return response()->json($mahasiswa);
    }
}
