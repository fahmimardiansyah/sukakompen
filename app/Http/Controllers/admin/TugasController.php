<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TugasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Tugas Page',
            'list' => ['Home', 'Tugas']
        ];

        $activeMenu = 'tugas';

        $tugasAdmin = TugasModel::whereHas('users', function ($query) {
            $query->where('level_id', 1); 
        })->get();

        $tugasDosen = TugasModel::whereHas('users', function ($query) {
            $query->where('level_id', 2); 
        })->get();

        $tugasTendik = TugasModel::whereHas('users', function ($query) {
            $query->where('level_id', 3);
        })->get();

        return view('admin.tugas.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'tugasAdmin' => $tugasAdmin,
            'tugasDosen' => $tugasDosen,
            'tugasTendik' => $tugasTendik
        ]);
    }

    public function create_ajax() {
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get(); // Data Jenis
        $kompetensi = KompetensiModel::select('kompetensi_id', 'kompetensi_nama')->get(); // Data Kompetensi
        $tipe = TugasModel::TIPE_ENUM;
    
        return view('admin.tugas.create_ajax', [
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
                'tugas_file' => ['nullable', 'file', 'mimes:doc,docx,pdf,ppt,pptx,xls,xlsx,zip,rar', 'max:20480']
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
                $data = $request->all();
                $data['tugas_No'] = (string) Str::uuid();
                $data['user_id'] = auth()->user()->user_id ?? null; 

                if ($request->hasFile('tugas_file')) {
                    $file = $request->file('tugas_file');
                    $fileName = time() . '_' . $file->getClientOriginalName(); // Buat nama file unik
                    $file->storeAs('uploads/tugas', $fileName, 'public'); // Simpan di direktori storage/app/public/uploads/tugas
                    $data['tugas_file'] = $fileName; // Simpan nama file ke database
                }
                
                TugasModel::create($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Data tugas berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
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

        return view('admin.tugas.detail', ['description' => $description, 'activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb, 'page' => $page]);
    }

    public function edit_ajax(string $id) {
        $tugas = TugasModel::find($id);
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get();
        $kompetensi = KompetensiModel::select('kompetensi_id', 'kompetensi_nama')->get();
        $tipe = TugasModel::TIPE_ENUM;

        return view('admin.tugas.edit_ajax', ['tugas' => $tugas, 'jenis' => $jenis, 'kompetensi' => $kompetensi, 'tipe' => $tipe]);
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
                'tugas_file' => ['nullable', 'file', 'mimes:doc,docx,pdf,ppt,pptx,xls,xlsx,zip,rar', 'max:20480'] // Maks 20MB
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
                    if ($request->hasFile('tugas_file')) {
                        $file = $request->file('tugas_file');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs('uploads/tugas', $filename, 'public'); // Simpan file ke direktori 'storage/app/public/uploads/tugas'
    
                        if ($check->tugas_file && Storage::disk('public')->exists('uploads/tugas/' . $check->tugas_file)) {
                            Storage::disk('public')->delete('uploads/tugas/' . $check->tugas_file);
                        }
    
                        $request->merge(['tugas_file' => $filename]); // Tambahkan nama file baru ke request
                    }
    
                    $check->update($request->all());
    
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage()
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(String $id){
        $tugas = TugasModel::find($id);

        return view('admin.tugas.confirm_ajax', ['tugas' => $tugas]);
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
