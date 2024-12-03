<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApprovalModel;
use App\Models\MahasiswaModel;
use App\Models\ProgressModel;
use Illuminate\Http\Request;
use App\Models\TugasModel;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIApprovalController extends Controller
{
    // function ketika mhs mengirim tugas
    public function kirim(Request $request)
    {
        $apply_id = $request->apply_id;

        if (is_null($apply_id)) {
            return response()->json(['message' => 'Apply ID is required'], 400);
        }

        $data = ProgressModel::where('apply_id', $apply_id)->first();

        if (!$data) {
            return response()->json(['message' => 'Progress not found'], 404);
        }

        try {
            $data->status = true;
            $data->save();

            $save = new ApprovalModel;
            $save->progress_id = $data->progress_id;
            $save->mahasiswa_id = $data->mahasiswa_id;
            $save->tugas_id = $data->tugas_id;
            $save->save();

            return response()->json(['message' => 'Task successfully submitted']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // function tampilan cek tugas di dosen
    public function cek_tugas(Request $request)
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

        $approval = ApprovalModel::whereIn('tugas_id', $tugasIds)->get();

        $approvalFiltered = $approval->filter(function ($item) {
            return $item->status === null;
        });

        if ($approvalFiltered->isEmpty()) {
            return response()->json(['message' => 'Tidak ada approval dengan status null'], 404);
        }

        $result = $tugas->filter(function ($tugasItem) use ($approvalFiltered) {
            return $approvalFiltered->contains('tugas_id', $tugasItem->tugas_id);
        })->map(function ($tugasItem) use ($approvalFiltered) {
            $relatedApproval = $approvalFiltered->where('tugas_id', $tugasItem->tugas_id);
            return [
                'tugas' => $tugasItem,
                'approval' => $relatedApproval->values(),
            ];
        });

        return response()->json($result);
    }

    public function detail(Request $request)
    {
        $validate = $request->validate([
            'tugas_id' => 'required|exists:t_tugas,tugas_id',
            'progress_id' => 'required|exists:t_progress,progress_id'
        ]);

        $tugas = TugasModel::find($validate['tugas_id']);
        if (!$tugas) {
            return response()->json(['message' => 'Data tugas tidak ditemukan'], 404);
        }

        $progress = ProgressModel::find($validate['progress_id']);
        if (!$progress) {
            return response()->json(['message' => 'Data progress tidak ditemukan'], 404);
        }

        $mahasiswa = MahasiswaModel::where('mahasiswa_id', $progress->mahasiswa_id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        return response()->json([
            'mahasiswa_nama' => $mahasiswa->mahasiswa_nama,
            'file_mahasiswa' => $progress->file_mahasiswa,
            'tugas_nama' => $tugas->tugas_nama,
            'tugas_deskripsi' => $tugas->tugas_deskripsi,
            'tugas_tenggat' => $tugas->tugas_tenggat,
            'tugas_tipe' => $tugas->tugas_tipe,
            'tugas_jam_kompen' => $tugas->tugas_jam_kompen,
            'tugas_alpha' => '-' . $tugas->tugas_jam_kompen . ' Jam Alpha',
        ], 200);
    }


    // function ketika tugas ditolak
    public function tolak(Request $request) {
        $data = ApprovalModel::all()->where('approval_id', $request->approval_id)->first();
        $data->status = false;
        $data->save();

        return 'Berhasil Mengubah Data';
    }

    // function ketika tugas diterima
    public function terima(Request $request) {
        $data = ApprovalModel::all()->where('approval_id', $request->approval_id)->first();
        $data->status = true;
        $data->save();

        return 'Berhasil Mengubah Data';
    }

}
