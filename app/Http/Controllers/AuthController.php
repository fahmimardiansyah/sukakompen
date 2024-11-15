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
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }

        return view('auth.login');
    }

    // public function postlogin(Request $request)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $credentials = $request->only('username', 'password');

    //         if (Auth::attempt($credentials)) {
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Login Berhasil',
    //                 'redirect' => url('/')
    //             ]);
    //         }

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Login Gagal'
    //         ]);
    //     }

    //     return redirect('login');
    // }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function register()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
    
        return view('auth.register')
            ->with('level', $level);
    }
    

    public function postlogin(Request $request)
{
    // Mengecek apakah request berupa AJAX atau membutuhkan respons dalam format JSON
    if ($request->ajax() || $request->wantsJson()) {
        
        // Mengambil data 'username' dan 'password' dari input request
        $credentials = $request->only('username', 'password');
        
        // Mencoba melakukan login dengan kredensial yang diberikan (username dan password)
        if (Auth::attempt($credentials)) {
            
            // Jika login berhasil, menyimpan informasi profil pengguna ke dalam session
            session([
                'profile_img_path' => Auth::user()->foto,   // Menyimpan foto profil pengguna
                'user_id' => Auth::user()->user_id            // Menyimpan ID pengguna
            ]);
            
            // Mengirimkan response JSON yang menunjukkan bahwa login berhasil, beserta URL untuk redirect
            return response()->json([
                'status' => true,                            // Status keberhasilan login
                'message' => 'Login Berhasil',               // Pesan sukses
                'redirect' => url('/')                       // URL untuk redirect ke halaman utama
            ]);
        }
        
        // Jika login gagal (misalnya username atau password salah)
        return response()->json([
            'status' => false,                             // Status kegagalan login
            'message' => 'Login Gagal'                    // Pesan kegagalan login
        ]);
    }
    
    // Jika request bukan berupa AJAX, maka mengarahkan pengguna ke halaman login biasa
    return redirect('login');
}

        // Membuat fungsi store Ajax
    public function postregister(Request $request)
    {
        //cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:6'
            ];
    
            //use Illumintae\support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }
    
            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan',
                redirect('login')
            ]);

            return redirect('login');
        }
    }

    public function dashboard()
    {
    $user = Auth::user();
    $level = $user->level_id; // Misalkan level_id disimpan di user

    return view('dashboard', compact('level'));
    }

}