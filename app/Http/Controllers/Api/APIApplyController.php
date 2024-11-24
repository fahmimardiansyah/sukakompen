<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\MahasiswaModel;
use App\Models\ProgressModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIApplyController extends Controller
{
    public function show(Request $request)
    {
        $validate = $request->validate([
            'tugas_id' => 'required|exists:t_tugas,tugas_id',
        ]);

        $tugas = TugasModel::find($validate['tugas_id']);

        if (!$tugas) {
            return response()->json(['message' => 'Data tugas tidak ditemukan'], 404);
        }

        // Format respons dengan data tambahan
        return response()->json([
            'tugas_nama' => $tugas->tugas_nama,
            'tugas_deskripsi' => $tugas->tugas_deskripsi,
            'tugas_tenggat' => $tugas->tugas_tenggat,
            'tugas_tipe' => $tugas->tugas_tipe,
            'tugas_jam_kompen' => $tugas->tugas_jam_kompen,
            'tugas_alpha' => '-' . $tugas->tugas_jam_kompen . ' Jam Alpha',
        ], 200);
    }

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

        $apply = ApplyModel::whereIn('tugas_id', $tugasIds)->get();

        $applyFiltered = $apply->filter(function ($item) {
            return $item->apply_status === null;
        });

        if ($applyFiltered->isEmpty()) {
            return response()->json(['message' => 'Tidak ada apply dengan status null'], 404);
        }

        $result = $tugas->filter(function ($tugasItem) use ($applyFiltered) {
            return $applyFiltered->contains('tugas_id', $tugasItem->tugas_id);
        })->map(function ($tugasItem) use ($applyFiltered) {
            $relatedApply = $applyFiltered->where('tugas_id', $tugasItem->tugas_id);
            return [
                'tugas' => $tugasItem,
                'apply' => $relatedApply->values(),
            ];
        });

        return response()->json($result);
    }

    // function ketika apply ditolak
    public function decline(Request $request) {
        $data = ApplyModel::all()->where('apply_id', $request->apply_id)->first();
        $data->apply_status = false;
        $data->save();

        return 'Berhasil Mengubah Data';
    }

    // function ketika apply diterima dan auto update untuk progress
    public function acc(Request $request) {
        $data = ApplyModel::all()->where('apply_id', $request->apply_id)->first();
        $data->apply_status = true;
        $data->save();

        $save = new ProgressModel;
        $save->apply_id = $data->apply_id;
        $save->mahasiswa_id = $data->mahasiswa_id;
        $save->tugas_id = $data->tugas_id;
        $save->status = false;
        $save->save();

        return 'Berhasil Mengubah Data';
    }

    // apply untuk mahasiswa 
    public function apply(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $validate = $request->validate([
            'tugas_id' => 'required|exists:t_tugas,tugas_id',
        ]);

        $tugas = TugasModel::find($validate['tugas_id']);

        $apply = new ApplyModel();
        $apply->mahasiswa_id = $mahasiswa->mahasiswa_id;
        $apply->tugas_id = $tugas->tugas_id;
        $apply->save();

        return response()->json(['message' => 'Berhasil menyimpan data'], 201);
    }
        
}
