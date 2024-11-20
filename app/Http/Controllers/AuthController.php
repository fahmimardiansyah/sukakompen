<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $redirectRoute = $this->getRedirectRoute($user->getRole());
    
            return redirect(url($redirectRoute));
        }
    
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                $user = UserModel::with('level')->where('username', $request->username)->first();
                Auth::login($user); 
            
                session([
                    'profile_img_path' => $user->foto,
                    'user_id' => $user->user_id,
                ]);
            
                $redirectRoute = $this->getRedirectRoute($user->getRole());
            
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url($redirectRoute),
                ]);
            }        
            return redirect('login');
        }
    }

    public function register()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
    
        return view('auth.register')
            ->with('level', $level);
    }

    public function postregister(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:5'
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // Pesan error validasi
                ]);
            }

            // Simpan data user
            UserModel::create([
                'level_id' => $request->level_id,
                'username' => $request->username,
                'nama'     => $request->nama,
                'password' => bcrypt($request->password), // Enkripsi password
            ]);

            // Kirim respons JSON dengan URL redirect
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan',
                'redirect' => url('login'), // URL login dikirimkan ke client
            ]);
        }

        // Jika bukan AJAX, redirect langsung
        return redirect('login');
    }

        /**
     * Menentukan route redirect berdasarkan level_kode.
     *
     * @param string $level_kode
     * @return string
     */
    private function getRedirectRoute($level_kode)
    {
        switch ($level_kode) {
            case 'ADM':
                return '/welcome';
            case 'DSN':
            case 'TDK':
                return '/landing';
            case 'MHS':
                return '/dashboardmhs';
            default:
                return '/'; // Default ke halaman home jika level_kode tidak dikenali
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

}