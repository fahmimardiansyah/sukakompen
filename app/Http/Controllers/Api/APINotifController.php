<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\MahasiswaModel;
use App\Models\ProgressModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class APINotifController extends Controller
{
    // notif di mhs untuk diterima
    public function notifTerimaApply(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $apply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas') 
            ->get();

        $applyGrouped = $apply->groupBy('apply_status');

        $applyAccepted = $applyGrouped->get(1, collect());

        $result = [
            'accepted' => $applyAccepted->map(function ($applyItem) {
                return [
                    'apply_id' => $applyItem->apply_id,
                    'status' => 'accepted',
                    'tugas' => $applyItem->tugas,
                ];
            })->values(),
        ];

        return response()->json($result);
    }

    // notif di mhs untuk ditolak
    public function notifTolakApply(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $apply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas') 
            ->get();

        $applyGrouped = $apply->groupBy('apply_status');

        $applyAccepted = $applyGrouped->get(0, collect());

        $result = [
            'declined' => $applyAccepted->map(function ($applyItem) {
                return [
                    'apply_id' => $applyItem->apply_id,
                    'status' => 'declined',
                    'tugas' => $applyItem->tugas,
                ];
            })->values(),
        ];

        return response()->json($result);
    }
}
