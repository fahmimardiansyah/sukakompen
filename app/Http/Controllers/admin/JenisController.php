<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisModel;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;
class JenisController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Jenis Tugas Page',
            'list' => ['Home', 'Jenis Tugas']
        ];

        $activeMenu = 'jenis';

        $jenis = JenisModel::all();

        return view('admin.jenis.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'jenis' => $jenis]);
    }

    public function create_ajax() {
        return view('admin.jenis.create_ajax');
    }

    public function store_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_kode' => 'required|string|min:3|unique:m_jenis,jenis_kode',
                'jenis_nama' => 'required|string|max:100',
                'jenis_deskripsi' => 'required|string|max:500'
            ] ;

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            JenisModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Level berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id) {
        $jenis = JenisModel::find($id);

        return view('admin.jenis.edit_ajax', ['jenis' => $jenis]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_kode' => 'required|string|min:3|unique:m_jenis,jenis_kode,' . $id . ',jenis_id',
                'jenis_nama' => 'required|string|max:100',
                'jenis_deskripsi' => 'required|string|max:500'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = JenisModel::find($id);

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

        return view('admin.jenis.confirm_ajax', ['jenis' => $jenis]);
    }

    public function delete_ajax (Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {

            $user = JenisModel::find($id);

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
