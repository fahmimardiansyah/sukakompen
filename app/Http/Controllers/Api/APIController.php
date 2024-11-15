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
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UserModel::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401); 
        }

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful',
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