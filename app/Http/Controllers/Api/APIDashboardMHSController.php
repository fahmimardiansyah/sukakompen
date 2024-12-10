<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use App\Models\TugasModel;
use App\Models\ApprovalModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIDashboardMHSController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan JWTAuth untuk mendapatkan user terautentikasi
        try {
            $user = JWTAuth::parseToken()->authenticate(); // Verifikasi dan ambil user berdasarkan token
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token tidak valid atau expired'], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        // Mendapatkan data mahasiswa berdasarkan user_id
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Ambil data tugas
        $tugas = TugasModel::all();

        // Ambil tugas berdasarkan user_id dan filter berdasarkan status approval
        $tugasIds = $tugas->pluck('tugas_id');
        $approval = ApprovalModel::whereIn('tugas_id', $tugasIds)->get();

        $approvalFiltered = $approval->filter(function ($item) {
            return $item->status === null;  // Mengambil approval dengan status null
        });

        if ($approvalFiltered->isEmpty()) {
            return response()->json(['message' => 'Tidak ada approval dengan status null'], 404);
        }

        // Filter tugas yang memiliki approval dengan status null
        $result = $tugas->filter(function ($tugasItem) use ($approvalFiltered) {
            return $approvalFiltered->contains('tugas_id', $tugasItem->tugas_id);
        })->map(function ($tugasItem) use ($approvalFiltered) {
            $relatedApproval = $approvalFiltered->where('tugas_id', $tugasItem->tugas_id);
            return [
                'tugas' => $tugasItem,
                'approval' => $relatedApproval->values(),
            ];
        });

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'tugas' => $result,  // Mengirimkan tugas yang sudah difilter dengan status approval
        ]);
    }
}

