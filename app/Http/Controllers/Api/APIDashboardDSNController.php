<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use App\Models\TugasModel;
use App\Models\ApplyModel;
use App\Models\MahasiswaModel;
use App\Models\TendikModel;
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

        $tendik = TendikModel::where('user_id', $user->user_id)->first();

        if (!$dosen && !$tendik) {
            return response()->json(['error' => 'Dosen atau Tendik tidak ditemukan'], 404);
        }

        $userData = null;
        if ($dosen) {
            $userData = $dosen;
        } elseif ($tendik) {
            $userData = $tendik;
        }

        $tugas = TugasModel::where('user_id', $user->user_id)->get();

        if ($tugas->isEmpty()) {
            return response()->json(['message' => 'Data tugas tidak ditemukan untuk user ini'], 404);
        }

        $tugasIds = $tugas->pluck('tugas_id');

        $apply = ApplyModel::whereIn('tugas_id', $tugasIds)
            ->whereNull('apply_status') 
            ->orderBy('apply_id')
            ->get();

        if ($apply->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data apply'], 404);
        }

        $result = $apply->map(function ($applyItem) use ($tugas) {
            $tugasItem = $tugas->firstWhere('tugas_id', $applyItem->tugas_id);
            $mahasiswa = MahasiswaModel::find($applyItem->mahasiswa_id);

            return [
                'apply_id' => $applyItem->apply_id,
                'tugas' => [
                    'tugas_id' => $tugasItem->tugas_id ?? null,
                    'tugas_nama' => $tugasItem->tugas_nama ?? null,
                    'tugas_deskripsi' => $tugasItem->tugas_deskripsi ?? null,
                ],
                'mahasiswa' => [
                    'nim' => $mahasiswa->nim ?? null,
                    'mahasiswa_nama' => $mahasiswa->mahasiswa_nama ?? null,
                ],
            ];
        });

        return response()->json([
            'user' => $userData, 
            'data' => $result
        ]);
    }
}
