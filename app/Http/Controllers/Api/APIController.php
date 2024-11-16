<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('username', 'password');

        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password Anda Salah',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }

    public function postRegister(Request $request)
    {
        $save = new UserModel;
        $save->level_id = $request->level_id;
        $save->username = $request->username;
        $save->nama = $request->nama;
        $save->password = $request->password;
        $save->save();

        return "Berhasil Menyimpan Data";
    }

    public function getLevels()
    {
        try {
            $levels = LevelModel::all()->select('level_id', 'level_nama');

            return response()->json([
                'success' => true,
                'data' => $levels
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data levels: ' . $e->getMessage()
            ], 500);
        }
    }
}