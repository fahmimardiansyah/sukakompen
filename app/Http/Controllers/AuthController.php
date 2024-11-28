<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\DosenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\TendikModel;
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
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer|in:1,2,3,4',
            ];

            switch ($request->level_id) {
                case 1: // Admin
                    $rules['nip'] = 'required|string|max:20|unique:m_admin,nip';
                    $rules['admin_nama'] = 'required|string|max:100';
                    $rules['admin_no_telp'] = 'required|string|max:15';
                    break;
                case 2: // Dosen
                    $rules['nidn'] = 'required|string|max:20|unique:m_dosen,nidn';
                    $rules['dosen_nama'] = 'required|string|max:100';
                    $rules['dosen_no_telp'] = 'required|string|max:15';
                    break;
                case 3: // Tendik
                    $rules['nip'] = 'required|string|max:20|unique:m_tendik,nip';
                    $rules['tendik_nama'] = 'required|string|max:100';
                    $rules['tendik_no_telp'] = 'required|string|max:15';
                    break;
                case 4: // Mahasiswa
                    $rules['nim'] = 'required|string|max:20|unique:m_mahasiswa,nim';
                    $rules['mahasiswa_nama'] = 'required|string|max:100';
                    $rules['prodi'] = 'required|string|max:100';
                    $rules['semester'] = 'required|integer|min:1';
                    break;
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $user = new UserModel();
            $user->level_id = $request->level_id;

            if ($request->level_id == 1) { // Admin
                $user->username = $request->nip;
            } elseif ($request->level_id == 2) { // Dosen
                $user->username = $request->nidn;
            } elseif ($request->level_id == 3) { // Tendik
                $user->username = $request->nip;
            } elseif ($request->level_id == 4) { // Mahasiswa
                $user->username = $request->nim;
            }
            $user->password = bcrypt($user->username); // Default password
            $user->save();

            if ($request->level_id == 1) { // Admin
                AdminModel::create([
                    'user_id' => $user->user_id,
                    'nip' => $request->nip,
                    'admin_nama' => $request->admin_nama,
                    'admin_no_telp' => $request->admin_no_telp,
                ]);
            } elseif ($request->level_id == 2) { // Dosen
                DosenModel::create([
                    'user_id' => $user->user_id,
                    'nidn' => $request->nidn,
                    'dosen_nama' => $request->dosen_nama,
                    'dosen_no_telp' => $request->dosen_no_telp,
                ]);
            } elseif ($request->level_id == 3) { // Tendik
                TendikModel::create([
                    'user_id' => $user->user_id,
                    'nip' => $request->nip,
                    'tendik_nama' => $request->tendik_nama,
                    'tendik_no_telp' => $request->tendik_no_telp,
                ]);
            } elseif ($request->level_id == 4) { // Mahasiswa
                MahasiswaModel::create([
                    'user_id' => $user->user_id,
                    'nim' => $request->nim,
                    'mahasiswa_nama' => $request->mahasiswa_nama,
                    'prodi' => $request->prodi,
                    'semester' => $request->semester,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan',
                'redirect' => url('login'),
            ]);
        }

        return redirect('login');
    }

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