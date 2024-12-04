<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TendikModel;

class APIProfileTDKController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $tendik = TendikModel::where('user_id', $user->user_id)->first();

        if (!$tendik) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }
        
        return response()->json($tendik);
    }
}
