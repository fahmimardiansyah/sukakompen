<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\ApplyModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\ProgressModel;
use App\Models\TendikModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Carbon;

class APIApplyController extends Controller
{
    // untuk tampilan apply approval dosen/tendik
    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $tugas = TugasModel::where('user_id', $user->user_id)->get();

        if ($tugas->isEmpty()) {
            return response()->json(['message' => 'Data tugas tidak ditemukan untuk user ini'], 404);
        }

        $tugasIds = $tugas->pluck('tugas_id');

        $apply = ApplyModel::whereIn('tugas_id', $tugasIds)
            ->whereNull('apply_status')  // This ensures only records with apply_status = null are selected
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

        return response()->json(['data' => $result]);
    }

    public function decline(Request $request) {
        $data = ApplyModel::all()->where('apply_id', $request->apply_id)->first();
        $data->apply_status = false;
        $data->save();

        return 'Berhasil Mengubah Data';
    }

    public function acc(Request $request)
    {
        try {
            $validate = $request->validate([
                'apply_id' => 'required|exists:t_apply,apply_id',
            ]);

            $data = ApplyModel::where('apply_id', $request->apply_id)->first();

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data apply tidak ditemukan',
                ], 404);
            }
            $data->apply_status = true;
            $data->save();

            $save = new ProgressModel();
            $save->apply_id = $data->apply_id;
            $save->mahasiswa_id = $data->mahasiswa_id;
            $save->tugas_id = $data->tugas_id;
            $save->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data dan menambahkan progress',
                'apply' => $data,
                'progress' => $save,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // apply untuk mahasiswa 
    public function apply(Request $request)
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }
    
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
    
            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mahasiswa tidak ditemukan'
                ], 404);
            }
    
            $validate = $request->validate([
                'tugas_id' => 'required|exists:t_tugas,tugas_id',
            ]);
    
            $tugas = TugasModel::findOrFail($validate['tugas_id']);
    
            $alreadyApplied = ApplyModel::where('tugas_id', $tugas->tugas_id)
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->exists();
    
            if ($alreadyApplied) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda sudah mendaftar untuk tugas ini.'
                ], 400);
            }
    
            $pendingApply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->whereNull('apply_status')
                ->exists();
    
            if ($pendingApply) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda sudah apply tugas lain, tunggu hingga diterima atau ditolak.'
                ], 400);
            }
    
            $unfinishedProgress = ProgressModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->whereNull('status')
                ->exists();
    
            if ($unfinishedProgress) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda memiliki progress tugas yang belum selesai.'
                ], 400);
            }
    
            ApplyModel::create([
                'tugas_id' => $tugas->tugas_id,
                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Pendaftaran tugas berhasil.'
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }    
        
}
