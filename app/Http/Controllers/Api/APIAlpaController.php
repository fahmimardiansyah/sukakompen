<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlpaModel;

class APIAlpaController extends Controller
{
    public function index()
    {
        $mahasiswa = AlpaModel::all();
        return response()->json($mahasiswa);
    }
}
