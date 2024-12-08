<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\TugasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $breadcrumb = (object) [
            'title' => 'Tugas Page',
            'list' => ['Home', 'Tugas']
        ];

        $activeMenu = 'kompen';

        $tugas = TugasModel::where('user_id', $user->user_id)->get();

        return view('dosen_tendik.kompen.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'tugas' => $tugas,
        ]);
    }


    public function create_ajax() {
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get(); // Data Jenis
        $kompetensi = KompetensiModel::select('kompetensi_id', 'kompetensi_nama')->get(); // Data Kompetensi
        $tipe = TugasModel::TIPE_ENUM;
    
        return view('dosen_tendik.kompen.create_ajax', [
            'tipe' => $tipe,
            'jenis' => $jenis,
            'kompetensi' => $kompetensi
        ]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tugas_nama' => ['required', 'string', 'min:3', 'max:100'],
                'jenis_id' => ['required', 'integer', 'exists:m_jenis,jenis_id'],
                'tugas_tipe' => ['required', 'in:' . implode(',', TugasModel::TIPE_ENUM)],
                'tugas_deskripsi' => ['required', 'string', 'max:500'],
                'tugas_kuota' => ['required', 'integer', 'max:10'],
                'tugas_jam_kompen' => ['required', 'integer', 'max:50'],
                'tugas_tenggat' => ['required', 'date'],
                'kompetensi_id' => ['required', 'integer', 'exists:t_kompetensi,kompetensi_id'],
                'file_tugas' => ['nullable', 'file', 'mimes:doc,docx,pdf,ppt,pptx,xls,xlsx,zip,rar', 'max:2048'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                $data = $request->except('file_tugas'); 
                $data['tugas_No'] = (string) Str::uuid();
                $data['user_id'] = auth()->user()->user_id ?? null;

                if ($request->hasFile('file_tugas')) {
                    $file = $request->file('file_tugas');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('posts/tugas', $fileName, 'public');
                    $data['file_tugas'] = $fileName;
                }                

                TugasModel::create($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Data tugas berhasil disimpan',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage(),
                ], 500);
            }
        }
        return redirect('/');
    }

    public function kompetensi($jenis_id)
    {
        $kompetensi = KompetensiModel::where('jenis_id', $jenis_id)->get();

        return response()->json($kompetensi);
    }

    public function detail($id)
    {
        $description = TugasModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Tugas',
            'list' => ['Home', 'Tugas', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Tugas'
        ];

        $activeMenu = 'tugas'; 

        $fileData = null;
        if ($description && $description->file_tugas) {
            $filePath = asset('storage/posts/tugas/' . $description->file_tugas);
            $fileName = basename($description->file_tugas);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $icons = [
                'pdf' => 'fas fa-file-pdf',
                'doc' => 'fas fa-file-word',
                'docx' => 'fas fa-file-word',
                'xls' => 'fas fa-file-excel',
                'xlsx' => 'fas fa-file-excel',
                'ppt' => 'fas fa-file-powerpoint',
                'pptx' => 'fas fa-file-powerpoint',
                'zip' => 'fas fa-file-archive',
                'rar' => 'fas fa-file-archive',
                'default' => 'fas fa-file',
            ];
            $iconClass = $icons[$fileExtension] ?? $icons['default'];

            $fileData = [
                'path' => $filePath,
                'name' => $fileName,
                'icon' => $iconClass,
            ];
        }

        return view('dosen_tendik.kompen.detail', [
            'description' => $description,
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'fileData' => $fileData,
        ]);
    }

    public function edit_ajax(string $id) {
        $tugas = TugasModel::find($id);
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get();
        $kompetensi = KompetensiModel::select('kompetensi_id', 'kompetensi_nama')->get();
        $tipe = TugasModel::TIPE_ENUM;

        return view('dosen_tendik.kompen.edit_ajax', ['tugas' => $tugas, 'jenis' => $jenis, 'kompetensi' => $kompetensi, 'tipe' => $tipe]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'tugas_nama' => ['required', 'string', 'min:3', 'max:100'],
                'jenis_id' => ['required', 'integer', 'exists:m_jenis,jenis_id'],
                'tugas_tipe' => ['required', 'in:' . implode(',', TugasModel::TIPE_ENUM)],
                'tugas_deskripsi' => ['required', 'string', 'max:500'],
                'tugas_kuota' => ['required', 'integer', 'max:10'],
                'tugas_jam_kompen' => ['required', 'integer', 'max:50'],
                'tugas_tenggat' => ['required', 'date'],
                'kompetensi_id' => ['required', 'integer', 'exists:t_kompetensi,kompetensi_id'],
                'file_tugas' => ['nullable', 'file', 'mimes:doc,docx,pdf,ppt,pptx,xls,xlsx,zip,rar', 'max:2048'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = TugasModel::find($id);

            if ($check) {
                try {
                    $data = $request->except('file_tugas');

                    if ($request->hasFile('file_tugas')) {
                        $file = $request->file('file_tugas');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs('posts/tugas', $filename, 'public');

                        if ($check->file_tugas && Storage::disk('public')->exists('posts/tugas/' . $check->file_tugas)) {
                            Storage::disk('public')->delete('posts/tugas/' . $check->file_tugas);
                        }

                        $data['file_tugas'] = $filename;
                    }

                    $check->update($data);

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage(),
                        'trace' => $e->getTraceAsString(), 
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        // Jika bukan request ajax, arahkan ke halaman utama
        return redirect('/');
    }

    public function confirm_ajax(String $id){
        $tugas = TugasModel::find($id);

        return view('dosen_tendik.kompen.confirm_ajax', ['tugas' => $tugas]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $tugas = TugasModel::find($id);
            if($tugas){
                $tugas->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
