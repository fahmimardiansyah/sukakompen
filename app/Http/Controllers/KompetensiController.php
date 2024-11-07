<?php

namespace App\Http\Controllers;

use App\Models\JenisModel;
use App\Models\KompetensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;

class KompetensiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kompetensi Tugas Page',
            'list' => ['Home', 'Kompetensi Tugas']
        ];

        $activeMenu = 'kompetensi';

        $kompetensi = KompetensiModel::all();
        $jenis = JenisModel::all();

        return view('kompetensi.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'kompetensi' => $kompetensi, 'jenis' => $jenis]);
    }

    public function create_ajax() {
        return view('kompetensi.create_ajax');
    }

    public function store_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_id'=> 'required|integer|exists:m_jenis,jenis_id',
                'kompetensi_kode' => 'required|string|min:3|unique:m_kompetensi,kompetensi_kode',
                'kompetensi_nama' => 'required|string|max:100',
                'komptensi_deskripsi' => 'required|string|max:500'
            ] ;

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KompetensiModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Level berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id) {
        $kompetensi = KompetensiModel::find($id);
        $jenis = JenisModel::find($id);

        return view('kompetensi.edit_ajax', ['kompetensi' => $kompetensi]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_id'=> 'required|integer|exists:m_jenis,jenis_id',
                'kompetensi_kode' => 'required|string|min:3|unique:m_kompetensi,kompetensi_kode',
                'kompetensi_nama' => 'required|string|max:100',
                'komptensi_deskripsi' => 'required|string|max:500'
            ] ;

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = KompetensiModel::find($id);

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

    public function confirm_ajax (string $id) {
        $jenis = JenisModel::find($id);
        $kompetensi = KompetensiModel::find($id);

        return view('kompetensi.confirm_ajax', ['kompetensi' => $kompetensi]);
    }

    public function delete_ajax (Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {

            $user = KompetensiModel::find($id);

            if ($user) {
                $user->delete();
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
