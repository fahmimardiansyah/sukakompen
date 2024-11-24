<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class APIDashboardDSNController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $dosen = DosenModel::where('user_id', $user->user_id)->first();

        if (!$dosen) {
            return response()->json(['error' => 'Dosen tidak ditemukan'], 404);
        }

        $tugas = TugasModel::all();

        return response()->json([
            'dosen' => $dosen,
            'tugas' => $tugas,
        ]);
    }
}
