<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\LevelModel;
use App\Models\TendikModel;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $credentials = $request->only('username', 'password');

            if (!$token = auth()->guard('api')->attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username atau Password Anda salah',
                ], 401);
            }

            $user = auth()->guard('api')->user();

            // Cek status aktif untuk dosen dan tendik
            $dosen = DosenModel::where('user_id', $user->user_id)->first();
            $tendik = TendikModel::where('user_id', $user->user_id)->first();

            if ($dosen && is_null($dosen->status)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Akun Anda belum aktif. Silakan register untuk mengaktifkan.',
                ], 403);
            }

            if ($tendik && is_null($tendik->status)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Akun Anda belum aktif. Silakan register untuk mengaktifkan.',
                ], 403);
            }

            // Buat response sukses
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'user' => [
                    auth()->guard('api')->user(),
                    'level_id' => (int) $user->level_id,
                    'level_nama' => $user->level->level_nama,
                ],
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
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

    public function logout(Request $request){
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        if($removeToken){
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        }
    }
}