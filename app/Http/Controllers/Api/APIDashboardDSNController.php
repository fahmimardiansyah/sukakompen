<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use App\Models\TugasModel;
use App\Models\ApplyModel;
use Illuminate\Http\Request;

class APIDashboardDSNController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        // Dapatkan data dosen berdasarkan user_id
        $dosen = DosenModel::where('user_id', $user->user_id)->first();

        if (!$dosen) {
            return response()->json(['error' => 'Dosen tidak ditemukan'], 404);
        }

        // Ambil semua tugas yang ada di dalam sistem
        $tugas = TugasModel::all();

        // Ambil semua apply yang sesuai dengan tugas yang diambil
        $apply = ApplyModel::whereIn('tugas_id', $tugas->pluck('tugas_id'))->get();

        // Gabungkan tugas dan apply berdasarkan tugas_id
        $result = $tugas->map(function ($tugasItem) use ($apply) {
            // Cari apply yang sesuai dengan tugas_id
            $relatedApply = $apply->where('tugas_id', $tugasItem->tugas_id);

            return [
                'tugas_id' => $tugasItem->tugas_id,
                'tugas_nama' => $tugasItem->tugas_nama,
                'tugas_deskripsi' => $tugasItem->tugas_deskripsi,
                'tugas_tenggat' => $tugasItem->tugas_tenggat,
                'tugas_tipe' => $tugasItem->tugas_tipe,
                'tugas_kuota' => $tugasItem->tugas_kuota,
                'tugas_jam_kompen' => $tugasItem->tugas_jam_kompen,
                'apply' => $relatedApply->map(function ($applyItem) {
                    return [
                        'apply_id' => $applyItem->apply_id,
                        'mahasiswa_id' => $applyItem->mahasiswa_id,
                        'apply_status' => $applyItem->apply_status,
                    ];
                })->values()
            ];
        });

        // Kirim respons JSON
        return response()->json([
            'dosen' => $dosen,
            'tugas' => $result,
        ]);
    }
}
