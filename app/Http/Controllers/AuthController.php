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
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail; 

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

                $dosen = DosenModel::where('user_id', $user->user_id)->first();
                $tendik = TendikModel::where('user_id', $user->user_id)->first();

                if ($dosen && is_null($dosen->status)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Akun Anda belum aktif. Silakan register untuk mengaktitfkan.',
                    ]);
                }

                if ($tendik && is_null($tendik->status)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Akun Anda belum aktif. Silakan register untuk mengaktitfkan.',
                    ]);
                }

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
        $level = LevelModel::select('level_id', 'level_nama')
            ->whereNot('level_id', 1)
            ->get();

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
                case 2:
                case 3:
                    $rules['username'] = 'required|string|max:255';
                    $rules['password'] = 'required|string|max:255';
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

            if (in_array($request->level_id, [2, 3])) {
                $existingUser = UserModel::where('username', $request->username)->first();
    
                if ($existingUser) {
                    $verificationCode = rand(100000, 999999); 
                    session(['verification_code_' . $existingUser->user_id => $verificationCode]);
                    session(['verification_code_timestamp_' . $existingUser->user_id => now()]); 
                    session(['existing_user_id' => $existingUser->user_id]);
                    session(['new_password_' . $existingUser->user_id => $request->password]); // Store the password in session
    
                    try {
                        $dosen = DosenModel::where('user_id', $existingUser->user_id)->first();
                        $tendik = TendikModel::where('user_id', $existingUser->user_id)->first();
    
                        if ($dosen) {
                            Mail::to($dosen->dosen_email)->send(new VerificationCodeMail($verificationCode)); 
                        } elseif ($tendik) {
                            Mail::to($tendik->tendik_email)->send(new VerificationCodeMail($verificationCode)); 
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Gagal mengirimkan kode verifikasi melalui email: ' . $e->getMessage(),
                        ]);
                    }
    
                    return response()->json([
                        'status' => true,
                        'message' => 'User sudah terdaftar. Silakan masukkan kode verifikasi.',
                        'modal' => [
                            'title' => 'Kode Verifikasi',
                            'content' => 'Kami telah mengirimkan kode verifikasi ke email Anda. Silakan masukkan kode tersebut di bawah ini.',
                            'action_url' => url('verifikasi/' . $existingUser->user_id),
                        ],
                    ]);
                }
            }

            DB::beginTransaction(); 
            try {
                $user = new UserModel();
                $user->level_id = $request->level_id;

                if ($request->level_id == 4) { 
                    $user->username = $request->nim;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'role tidak ditemukan',
                    ]);
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
                return '/';
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function verifikasi(Request $request)
    {
        $userId = session('existing_user_id');

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan. Coba lagi.',
            ]);
        }

        $user = UserModel::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ada.',
            ]);
        }

        $enteredCode = $request->verification_code;
        $storedCode = session('verification_code_' . $user->user_id);
        $timestamp = session('verification_code_timestamp_' . $user->user_id);

        if (!$storedCode || !$timestamp) {
            return response()->json([
                'status' => false,
                'message' => 'Kode verifikasi tidak ditemukan. Pastikan Anda telah meminta kode verifikasi sebelumnya. Jika belum, silakan coba lagi.'
            ]);
        }

        if (now()->diffInMinutes($timestamp) > 2) {
            return response()->json([
                'status' => false,
                'message' => 'Kode verifikasi telah kedaluwarsa. Mohon minta kode baru.'
            ]);
        }

        if ($enteredCode != $storedCode) {
            return response()->json([
                'status' => false,
                'message' => 'Kode verifikasi salah.',
            ]);
        }

        $newPassword = session('new_password_' . $user->user_id);
        if ($newPassword) {
            $user->password = bcrypt($newPassword);
            $user->save();
        }

        session()->forget('new_password_' . $user->user_id);

        $dosen = DosenModel::where('user_id', $user->user_id)->first();
        $tendik = TendikModel::where('user_id', $user->user_id)->first();

        if ($dosen) {
            $dosen->update([
                'status' => true
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Verifikasi berhasil. Password telah diperbarui.',
                'redirect' => url('login'), // Redirect to the correct page (e.g., dashboard or landing page)
            ]);
        } elseif ($tendik) {
            $tendik->update([
                'status' => true
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Verifikasi berhasil. Password telah diperbarui.',
                'redirect' => url('login'), // Redirect to the correct page for tendik
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'tidak menemukan user yang perlu diverifikasi.',
            ]);
        }
    }

}
