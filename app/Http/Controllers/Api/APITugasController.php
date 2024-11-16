<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\TugasModel;

class APITugasController extends Controller
{
    public function index()
    {
        $data = TugasModel::all();
        return $data;
    }

    public function store(Request $request)
    {
        $save = new TugasModel;
        $save->user_id = $request->user_id;
        $save->tugas_nama = $request->tugas_nama;
        $save['tugas_No'] = (string) Str::uuid();
        $save->jenis_id = $request->jenis_id;
        $save->tugas_tipe = $request->tugas_tipe;
        $save->tugas_deskripsi = $request->tugas_deskripsi;
        $save->tugas_kuota = $request->tugas_kuota;
        $save->tugas_jam_kompen = $request->tugas_jam_kompen;
        $save->tugas_tenggat = $request->tugas_tenggat;
        $save->kompetensi_id = $request->kompetensi_id;
        $save->save();

        return "Berhasil Menyimpan Data";
    }

    public function show(Request $request)
    {
        $data = TugasModel::all()->where("tugas_id", $request->tugas_id)->first();
        return $data;
    }

    public function edit(Request $request)
    {
        $data = TugasModel::all()->where("tugas_id", $request->tugas_id)->first();
        $data->tugas_nama = $request->tugas_nama;
        $data->jenis_id = $request->jenis_id;
        $data->tugas_tipe = $request->tugas_tipe;
        $data->tugas_deskripsi = $request->tugas_deskripsi;
        $data->tugas_kuota = $request->tugas_kuota;
        $data->tugas_jam_kompen = $request->tugas_jam_kompen;
        $data->tugas_tenggat = $request->tugas_tenggat;
        $data->kompetensi_id = $request->kompetensi_id;
        $data->save();

        return 'Berhasil Mengubah Data';
    }

    public function destroy(Request $request)
    {
        $del = TugasModel::all()->where('tugas_id', $request->tugas_id)->first();
        $del->delete();
        return "Berhasil Menghapus Data";
    }
}
