<?php

namespace App\Http\Controllers;

use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;
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

    return view('tugas.index', [
        'breadcrumb' => $breadcrumb,
        'activeMenu' => $activeMenu,
        'tugasAdmin' => $tugasAdmin,
        'tugasDosen' => $tugasDosen,
        'tugasTendik' => $tugasTendik
    ]);
}


    public function create_ajax() {
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get();

        $tipe = TugasModel::TIPE_ENUM;

        return view('tugas.create_ajax', ['tipe' => $tipe])
                    ->with('jenis', $jenis);
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
                'kompetensi_id' => ['required', 'integer', 'exists:t_kompetensi,kompetensi_id']
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
}