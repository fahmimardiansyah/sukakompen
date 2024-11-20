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
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Mendapatkan user yang sedang login

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


    public function create_ajax()
    {
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get();

        $tipe = TugasModel::TIPE_ENUM;

        return view('dosen_tendik.kompen.create_ajax', ['tipe' => $tipe])
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

        $activeMenu = 'kompen';

        return view('dosen_tendik.kompen.detail', ['description' => $description, 'activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb, 'page' => $page]);
    }

    public function edit_ajax(string $id)
    {
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
                'kompetensi_id' => ['required', 'integer', 'exists:t_kompetensi,kompetensi_id']
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
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(String $id)
    {
        $tugas = TugasModel::find($id);

        return view('dosen_tendik.kompen.confirm_ajax', ['tugas' => $tugas]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $tugas = TugasModel::find($id);
            if ($tugas) {
                $tugas->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
