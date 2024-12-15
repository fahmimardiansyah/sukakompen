<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;

class APIProfileMHSController extends Controller
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

        $userImageUrl = $user->image ?? null;

        if ($mahasiswa) {
            return response()->json([
                'data' => $mahasiswa,
                'prodi' => $mahasiswa->prodi->prodi_nama,
                'image_url' => $userImageUrl,
            ]);
        }
        
        return response()->json(['error' => 'Terjadi kesalahan'], 500);
    }
}
