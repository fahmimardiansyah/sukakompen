<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\KompetensiTgsModel;
use App\Models\TugasModel;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\TendikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

            $data = $data->map(function ($task) {
                $pembuat_tugas = 'Unknown';
                if ($task->users) {
                    $dosen = DosenModel::where('user_id', $task->users->user_id)->first();
                    $tendik = TendikModel::where('user_id', $task->users->user_id)->first();
                    $admin = AdminModel::where('user_id', $task->users->user_id)->first();

                    if ($dosen) {
                        $pembuat_tugas = $dosen->dosen_nama;
                    } elseif ($tendik) {
                        $pembuat_tugas = $tendik->tendik_nama;
                    } elseif ($admin) {
                        $pembuat_tugas = $admin->admin_nama;
                    }
                }

                $task->pembuat_tugas = $pembuat_tugas;
                return $task;
            });

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
        DB::beginTransaction();
        
        try {
            $validator = Validator::make($request->all(), [
                'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
                'kompetensi_id' => ['required', 'array', 'min:1'],
                'kompetensi_id.*' => ['integer', 'exists:t_kompetensi,kompetensi_id'],
                'tugas_nama' => 'required|string',
                'jenis_id' => 'required|integer|exists:m_jenis,jenis_id',
                'tugas_tipe' => 'required|string',
                'tugas_deskripsi' => 'required|string',
                'tugas_kuota' => 'required|integer',
                'tugas_jam_kompen' => 'required|integer',
                'tugas_tenggat' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = JWTAuth::parseToken()->authenticate();

            $save = new TugasModel();
            $save->user_id = $user->user_id;
            $save->tugas_nama = $request->tugas_nama;
            $save['tugas_No'] = (string) Str::uuid();
            $save->jenis_id = $request->jenis_id;
            $save->tugas_tipe = $request->tugas_tipe;
            $save->tugas_deskripsi = $request->tugas_deskripsi;
            $save->tugas_kuota = $request->tugas_kuota;
            $save->tugas_jam_kompen = $request->tugas_jam_kompen;
            $save->tugas_tenggat = $request->tugas_tenggat;

            if ($request->hasFile('file_tugas')) {
                $file = $request->file('file_tugas');
                $fileName = time() . '_' . $file->hashName();
                $file->storeAs('posts', $fileName, 'public');
                $save->file_tugas = $fileName;
            }

            $save->save();

            $kompetensiData = array_map(function ($kompetensiId) use ($save) {
                return [
                    'tugas_id' => $save->tugas_id,
                    'kompetensi_id' => $kompetensiId,
                ];
            }, $request->kompetensi_id);

            KompetensiTgsModel::insert($kompetensiData);

            DB::commit(); 

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menyimpan data',
                'data' => $save,
                'kompetensi' => $kompetensiData
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // untuk detail tugas dosen/tendik
    public function show(Request $request)
    {
        $data = TugasModel::where("tugas_id", $request->tugas_id)->first();

        if (!$data) {
            return response()->json(['message' => 'Data tugas tidak ditemukan'], 404);
        }

        $kompetensi = KompetensiTgsModel::where('tugas_id', $request->tugas_id)->get();

        $kompetensi_nama = $kompetensi->map(function ($item) {
            return $item->kompetensi->kompetensi_nama ?? 'Unknown';
        });

        return response()->json([
            'tugas' => $data,
            'kompetensi' => $kompetensi_nama
        ], 200);
    }

    // untuk edit tugas dosen/tendik
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tugas_id' => 'required|exists:t_tugas,tugas_id',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
            'tugas_nama' => 'required|string|max:255',
            'jenis_id' => 'required|exists:m_jenis,jenis_id',
            'tugas_tipe' => 'required|string',
            'tugas_deskripsi' => 'required|string',
            'tugas_kuota' => 'required|integer',
            'tugas_jam_kompen' => 'required|integer',
            'tugas_tenggat' => 'required|date',
            'kompetensi_id' => ['required', 'array', 'min:1'], 
            'kompetensi_id.*' => ['integer', 'exists:t_kompetensi,kompetensi_id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = TugasModel::find($request->tugas_id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($request->hasFile('file_tugas')) {
            if ($data->file_tugas) {
                $oldFilePath = storage_path('app/public/posts/' . $data->file_tugas);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('file_tugas');
            $fileName = time() . '_' . $file->hashName();
            $file->storeAs('posts', $fileName, 'public');
            $data->file_tugas = $fileName;
        }

        $data->tugas_nama = $request->tugas_nama;
        $data->tugas_No = (string) Str::uuid();
        $data->jenis_id = $request->jenis_id;
        $data->tugas_tipe = $request->tugas_tipe;
        $data->tugas_deskripsi = $request->tugas_deskripsi;
        $data->tugas_kuota = $request->tugas_kuota;
        $data->tugas_jam_kompen = $request->tugas_jam_kompen;
        $data->tugas_tenggat = $request->tugas_tenggat;
        $data->save();

        KompetensiTgsModel::where('tugas_id', $data->tugas_id)->delete();

        $kompetensiIds = $request->kompetensi_id;
        if (count($kompetensiIds) !== count(array_unique($kompetensiIds))) {
            return response()->json([
                'status' => false,
                'message' => 'Kompetensi ID duplikat ditemukan dalam input.'
            ], 422);
        }

        $kompetensiData = array_map(function ($kompetensiId) use ($data) {
            return [
                'tugas_id' => $data->tugas_id,
                'kompetensi_id' => $kompetensiId,
            ];
        }, $kompetensiIds);

        KompetensiTgsModel::insert($kompetensiData);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $data,
            'kompetensi' => $kompetensiData
        ], 200);
    }

    public function destroy(Request $request)
    {
        $del = TugasModel::all()->where('tugas_id', $request->tugas_id)->first();
        KompetensiTgsModel::where('tugas_id', $del->tugas_id)->delete();
        $del->delete();

        return "Berhasil Menghapus Data";
    }

    public function getJenisTugas()
    {
        $jenisTugas = JenisModel::all();
        return response()->json($jenisTugas);
    }

    public function getBidangKompetensi()
    {
        $bidangKompetensi = KompetensiModel::all();
        return response()->json($bidangKompetensi);
    }
}
