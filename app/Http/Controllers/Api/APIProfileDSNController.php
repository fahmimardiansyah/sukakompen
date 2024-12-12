<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DosenModel;
use App\Models\TendikModel;

class APIProfileDSNController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $dosen = DosenModel::where('user_id', $user->user_id)->first();

        $tendik = TendikModel::where('user_id', $user->user_id)->first();

        if (!$dosen && !$tendik) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $userImageUrl = $user->image ?? null; 

        if ($dosen) {
            return response()->json([
                'data' => $dosen,
                'image_url' => $userImageUrl,
            ]);
        } elseif ($tendik) {
            return response()->json([
                'data' => $tendik,
                'image_url' => $userImageUrl,
            ]);
        }

        return response()->json(['error' => 'Terjadi kesalahan'], 500);
    }

}
