<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class APITugasDosenController extends Controller
{
    // untuk lihat tugas dosen/tendik
    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengguna tidak ditemukan'
                ], 404);
            }

            $data = TugasModel::where('user_id', $user->user_id)->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan untuk user ini',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid atau tidak ditemukan',
            ], 401);
        }
    }

    // untuk tambah tugas dosen/tendik
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $save = new TugasModel;

        if ($save->file_tugas) {
            $oldFilePath = storage_path('app/public/posts/' . $save->file_tugas);

            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            
            $fileName = time() . '_' . $file->hashName();
            
            $file->storeAs('posts', $fileName, 'public');
            
            $save->user_id = $request->user_id;
            $save->tugas_nama = $request->tugas_nama;
            $save['tugas_No'] = (string) Str::uuid();
            $save->jenis_id = $request->jenis_id;
            $save->tugas_tipe = $request->tugas_tipe;
            $save->tugas_deskripsi = $request->tugas_deskripsi;
            $save->tugas_kuota = $request->tugas_kuota;
            $save->tugas_jam_kompen = $request->tugas_jam_kompen;
            $save->tugas_tenggat = $request->tugas_tenggat;
            $save->file_tugas = $fileName;
            $save->kompetensi_id = $request->kompetensi_id;
            $save->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan Data',
                'data' => $save
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Gagal mengupload file'], 500);
    }

    // untuk detail tugas dosen/tendik
    public function show(Request $request)
    {
        $data = TugasModel::all()->where("tugas_id", $request->tugas_id)->first();
        return $data;
    }

    // untuk edit tugas dosen/tendik
    public function edit(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'tugas_id' => 'required|exists:tugas,tugas_id',
        'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
        'tugas_nama' => 'required|string|max:255',
        'jenis_id' => 'required|exists:jenis,jenis_id',
        'tugas_tipe' => 'required|string',
        'tugas_deskripsi' => 'required|string',
        'tugas_kuota' => 'required|integer',
        'tugas_jam_kompen' => 'required|integer',
        'tugas_tenggat' => 'required|date',
        'kompetensi_id' => 'required|exists:kompetensi,kompetensi_id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Temukan data tugas
    $data = TugasModel::find($request->tugas_id);

    if (!$data) {
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    // Hapus file lama jika ada dan unggah file baru jika diberikan
    if ($request->hasFile('file_tugas')) {
        $oldFilePath = storage_path('app/public/posts/' . $data->file_tugas);

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $file = $request->file('file_tugas');
        $fileName = time() . '_' . $file;
        $file->storeAs('posts', $fileName, 'public');
        $data->file_tugas = $fileName;
    }

    // Perbarui data tugas
    $data->tugas_nama = $request->tugas_nama;
    $data->tugas_No = (string) Str::uuid();
    $data->jenis_id = $request->jenis_id;
    $data->tugas_tipe = $request->tugas_tipe;
    $data->tugas_deskripsi = $request->tugas_deskripsi;
    $data->tugas_kuota = $request->tugas_kuota;
    $data->tugas_jam_kompen = $request->tugas_jam_kompen;
    $data->tugas_tenggat = $request->tugas_tenggat;
    $data->kompetensi_id = $request->kompetensi_id;

    $data->save();

    return response()->json([
        'status' => true,
        'message' => 'Berhasil memperbarui data',
        'data' => $data,
    ], 200);
}

    // untuk delete tugas dosen/tendik
    public function destroy(Request $request)
    {
        $del = TugasModel::all()->where('tugas_id', $request->tugas_id)->first();
        $del->delete();
        return "Berhasil Menghapus Data";
    }

    // untuk mendapatkan jenis tugas
    public function getJenisTugas()
    {
        $jenisTugas = JenisModel::all();
        return response()->json($jenisTugas);
    }

    // untuk mendapatkan bidang kompetensi
    public function getBidangKompetensi()
    {
        $bidangKompetensi = KompetensiModel::all();
        return response()->json($bidangKompetensi);
    }
}
