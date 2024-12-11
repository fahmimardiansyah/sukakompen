<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\AkumulasiModel;
use App\Models\AlpaModel;
use App\Models\DosenModel;
use App\Models\KompetensiMhsModel;
use App\Models\KompetensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\TendikModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
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

        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();

        $kompetensi = KompetensiModel::select('kompetensi_id', 'kompetensi_nama')->get();
    
        return view('auth.register')
            ->with('level', $level)
            ->with('prodi', $prodi)
            ->with('kompetensi', $kompetensi);
    }

    public function postregister(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer|in:1,2,3,4',
            ];

            switch ($request->level_id) {
                case 1: 
                    $rules['nip'] = 'required|string|max:20|unique:m_admin,nip';
                    $rules['admin_nama'] = 'required|string|max:100';
                    $rules['admin_no_telp'] = 'required|string|max:15';
                    break;
                case 2:
                    $rules['nidn'] = 'required|string|max:20|unique:m_dosen,nidn';
                    $rules['dosen_nama'] = 'required|string|max:100';
                    $rules['dosen_no_telp'] = 'required|string|max:15';
                    break;
                case 3: 
                    $rules['nip'] = 'required|string|max:20|unique:m_tendik,nip';
                    $rules['tendik_nama'] = 'required|string|max:100';
                    $rules['tendik_no_telp'] = 'required|string|max:15';
                    break;
                case 4:
                    $rules['nim'] = 'required|string|max:20|unique:m_mahasiswa,nim';
                    $rules['mahasiswa_nama'] = 'required|string|max:100';
                    $rules['prodi_id'] = 'required|integer|in:1,2,3';
                    $rules['semester'] = 'required|integer|min:1|max:8';
                    $rules['kompetensi_id'] = 'required|array';
                    $rules['kompetensi_id.*'] = 'integer|exists:t_kompetensi,kompetensi_id';
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

            DB::beginTransaction(); // Start transaction
            try {
                $user = new UserModel();
                $user->level_id = $request->level_id;

                if ($request->level_id == 1) { 
                    $user->username = $request->nip;
                } elseif ($request->level_id == 2) { 
                    $user->username = $request->nidn;
                } elseif ($request->level_id == 3) { 
                    $user->username = $request->nip;
                } elseif ($request->level_id == 4) { 
                    $user->username = $request->nim;
                }
                $user->password = bcrypt($user->username); 
                $user->save();

                if ($request->level_id == 4) { 
                    $mahasiswa = MahasiswaModel::create([
                        'user_id' => $user->user_id,
                        'nim' => $request->nim,
                        'mahasiswa_nama' => $request->mahasiswa_nama,
                        'prodi_id' => $request->prodi_id,
                        'semester' => $request->semester,
                    ]);

                    $kompetensiData = [];
                    foreach ($request->kompetensi_id as $kompetensiId) {
                        $kompetensiData[] = [
                            'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                            'kompetensi_id' => $kompetensiId,
                        ];
                    }

                    KompetensiMhsModel::insert($kompetensiData);

                    $alpa = AlpaModel::where('mahasiswa_alpa_nim', $mahasiswa->nim)->first();

                    $mahasiswa->update([
                        'jumlah_alpa' => $alpa->jam_alpa
                    ]);

                    for ($i = 1; $i <= 8; $i++) {
                        if ($alpa) {
                            $akumulasi = $i == $mahasiswa->semester;

                            if ($akumulasi) {
                                AkumulasiModel::create([
                                    'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                                    'semester' => $i,
                                    'jumlah_alpa' => $alpa->jam_alpa
                                ]);
                            } else {
                                AkumulasiModel::create([
                                    'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                                    'semester' => $i,
                                    'jumlah_alpa' => 0
                                ]);
                            }
                        } else {
                            AkumulasiModel::create([
                                'mahasiswa_id' => $mahasiswa->mahasiswa_id,
                                'semester' => $i,
                                'jumlah_alpa' => 0
                            ]);
                        }
                    }
                }

                DB::commit(); 
                return response()->json([
                    'status' => true,
                    'message' => 'Data user berhasil disimpan',
                    'redirect' => url('login'),
                ]);
            } catch (\Exception $e) {
                DB::rollBack(); 
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ]);
            }
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