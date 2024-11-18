<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class APITugasController extends Controller
{
    // untuk list tugas mahasiswa
    public function index()
    {
        $data = TugasModel::all();
        return $data;
    }

    public function show(Request $request)
    {
        $data = TugasModel::all()->where("tugas_id", $request->tugas_id)->first();
        return $data;
    }
}
