<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use App\Models\TendikModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class APINotifController extends Controller
{

    public function show(Request $request)
    {
        $validate = $request->validate([
            'tugas_id' => 'required|exists:t_tugas,tugas_id',
        ]);

        $tugas = TugasModel::find($validate['tugas_id']);

        if (!$tugas) {
            return response()->json(['message' => 'Data tugas tidak ditemukan'], 404);
        }

        return response()->json([
            'tugas_nama' => $tugas->tugas_nama,
            'tugas_deskripsi' => $tugas->tugas_deskripsi,
            'tugas_tenggat' => $tugas->tugas_tenggat,
            'tugas_tipe' => $tugas->tugas_tipe,
            'tugas_jam_kompen' => $tugas->tugas_jam_kompen,
            'tugas_alpha' => '-' . $tugas->tugas_jam_kompen . ' Jam Alpha',
            'file_tugas' => $tugas->file_tugas,
        ], 200);
    }

    // notif di mhs untuk apply diterima
    public function notifTerimaApply(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $apply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with(['tugas', 'tugas.users']) 
            ->get();

        $applyGrouped = $apply->groupBy('apply_status');

        if (!$applyGrouped->has(1)) {
            return response()->json(['message' => 'apply diterima tidak ditemukan'], 404);
        }

        $applyAccepted = $applyGrouped->get(1, collect());

        $result = [
            'accepted' => $applyAccepted->map(function ($applyItem) {

                $tugas = $applyItem->tugas; 
                
                if (!$tugas) {
                    return null; 
                }

                $dosen = DosenModel::where('user_id', $tugas->user_id)->first(); 

                $tendik = TendikModel::where('user_id', $tugas->user_id)->first(); 

                $admin = AdminModel::where('user_id', $tugas->user_id)->first();

                $pemberiTugas = null;

                if ($dosen) {
                    $pemberiTugas = [
                        'nidn' => $dosen->nidn,
                        'dosen_nama' => $dosen->dosen_nama,
                        'dosen_no_telp' => $dosen->dosen_no_telp
                    ];
                } elseif ($tendik) {
                    $pemberiTugas = [
                        'nip' => $tendik->nip,
                        'tendik_nama' => $tendik->tendik_nama,
                        'tendik_no_telp' => $tendik->tendik_no_telp,
                    ];
                } elseif ($admin) {
                    $pemberiTugas = [
                        'nip' => $admin->nip,
                        'admin_nama' => $admin->admin_nama,
                        'admin_no_telp' => $admin->admin_no_telp,
                    ];
                }


                return [
                    'apply_id' => $applyItem->apply_id,
                    'status' => 'accepted',
                    'tugas' => [
                        'tugas_id' => $tugas->tugas_id,
                        'user_id' => $tugas->user_id,
                        'tugas_nama' => $tugas->tugas_nama,
                        'tugas_tipe' => $tugas->tugas_tipe,
                        'tugas_deskripsi' => $tugas->tugas_deskripsi,
                        'tugas_tenggat' => $tugas->tugas_tenggat,
                        'pemberi_tugas' => $pemberiTugas,
                    ],
                ];
            })->values(),
        ];

        return response()->json($result);
    }

    // notif di mhs untuk apply ditolak
    public function notifTolakApply(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $apply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with(['tugas', 'tugas.users']) 
            ->get();

        $applyGrouped = $apply->groupBy('apply_status');

        if (!$applyGrouped->has(0)) {
            return response()->json(['message' => 'apply ditolak tidak ditemukan'], 404);
        }

        $applyAccepted = $applyGrouped->get(0, collect());

        $result = [
            'declined' => $applyAccepted->map(function ($applyItem) {

                $tugas = $applyItem->tugas; 
                
                if (!$tugas) {
                    return null; 
                }

                $dosen = DosenModel::where('user_id', $tugas->user_id)->first(); 

                $tendik = TendikModel::where('user_id', $tugas->user_id)->first();
                
                $admin = AdminModel::where('user_id', $tugas->user_id)->first();

                $pemberiTugas = null;

                if ($dosen) {
                    $pemberiTugas = [
                        'nidn' => $dosen->nidn,
                        'dosen_nama' => $dosen->dosen_nama,
                        'dosen_no_telp' => $dosen->dosen_no_telp
                    ];
                } elseif ($tendik) {
                    $pemberiTugas = [
                        'nip' => $tendik->nip,
                        'tendik_nama' => $tendik->tendik_nama,
                        'tendik_no_telp' => $tendik->tendik_no_telp,
                    ];
                } elseif ($admin) {
                    $pemberiTugas = [
                        'nip' => $admin->nip,
                        'admin_nama' => $admin->admin_nama,
                        'admin_no_telp' => $admin->admin_no_telp,
                    ];
                }

                return [
                    'apply_id' => $applyItem->apply_id,
                    'status' => 'declined',
                    'tugas' => [
                        'tugas_id' => $tugas->tugas_id,
                        'user_id' => $tugas->user_id,
                        'tugas_nama' => $tugas->tugas_nama,
                        'tugas_tipe' => $tugas->tugas_tipe,
                        'tugas_deskripsi' => $tugas->tugas_deskripsi,
                        'tugas_tenggat' => $tugas->tugas_tenggat,
                        'pemberi_tugas' => $pemberiTugas,
                    ],
                ];
            })->values(),
        ];

        return response()->json($result);
    }

    // notif di mhs untuk tugas diterima
    public function notifTerimaTugas(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $approval = ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with(['tugas', 'tugas.users']) 
            ->get();

        $approvalGrouped = $approval->groupBy('status');

        if (!$approvalGrouped->has(1)) {
            return response()->json(['message' => 'Tugas diterima tidak ditemukan'], 404);
        }

        $approvalAccepted = $approvalGrouped->get(1, collect());

        $result = [
            'accept' => $approvalAccepted->map(function ($approvalItem) {

                $tugas = $approvalItem->tugas; 
                
                if (!$tugas) {
                    return null; 
                }

                $dosen = DosenModel::where('user_id', $tugas->user_id)->first(); 

                $tendik = TendikModel::where('user_id', $tugas->user_id)->first(); 

                $admin = AdminModel::where('user_id', $tugas->user_id)->first();

                $pemberiTugas = null;

                if ($dosen) {
                    $pemberiTugas = [
                        'nidn' => $dosen->nidn,
                        'dosen_nama' => $dosen->dosen_nama,
                        'dosen_no_telp' => $dosen->dosen_no_telp
                    ];
                } elseif ($tendik) {
                    $pemberiTugas = [
                        'nip' => $tendik->nip,
                        'tendik_nama' => $tendik->tendik_nama,
                        'tendik_no_telp' => $tendik->tendik_no_telp,
                    ];
                } elseif ($admin) {
                    $pemberiTugas = [
                        'nip' => $admin->nip,
                        'admin_nama' => $admin->admin_nama,
                        'admin_no_telp' => $admin->admin_no_telp,
                    ];
                }


                return [
                    'approval_id' => $approvalItem->approval_id,
                    'status' => 'accept',
                    'tugas' => [
                        'tugas_id' => $tugas->tugas_id,
                        'user_id' => $tugas->user_id,
                        'tugas_nama' => $tugas->tugas_nama,
                        'tugas_tipe' => $tugas->tugas_tipe,
                        'tugas_deskripsi' => $tugas->tugas_deskripsi,
                        'tugas_tenggat' => $tugas->tugas_tenggat,
                        'pemberi_tugas' => $pemberiTugas,
                    ],
                ];
            })->values(),
        ];

        return response()->json($result);
    }


    // notif di mhs untuk approval ditolak
    public function notifTolakTugas(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $approval = ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with(['tugas', 'tugas.users'])
            ->get();

        if ($approval->isEmpty()) {
            return response()->json(['message' => 'tidak ada records approval'], 404);
        }

        $approvalGrouped = $approval->groupBy('status');
        
        if (!$approvalGrouped->has(0)) {
            return response()->json(['message' => 'tugas ditolak tidak ditemukan'], 404);
        }

        $approvalAccepted = $approvalGrouped->get(0, collect());

        $result = [
            'decline' => $approvalAccepted->map(function ($approvalItem) {

                $tugas = $approvalItem->tugas;

                if (!$tugas) {
                    return null;
                }

                $dosen = DosenModel::where('user_id', $tugas->user_id)->first();
                $tendik = TendikModel::where('user_id', $tugas->user_id)->first();
                $admin = AdminModel::where('user_id', $tugas->user_id)->first();

                $pemberiTugas = null;

                if ($dosen) {
                    $pemberiTugas = [
                        'nidn' => $dosen->nidn,
                        'dosen_nama' => $dosen->dosen_nama,
                        'dosen_no_telp' => $dosen->dosen_no_telp,
                    ];
                } elseif ($tendik) {
                    $pemberiTugas = [
                        'nip' => $tendik->nip,
                        'tendik_nama' => $tendik->tendik_nama,
                        'tendik_no_telp' => $tendik->tendik_no_telp,
                    ];
                } elseif ($admin) {
                    $pemberiTugas = [
                        'nip' => $admin->nip,
                        'admin_nama' => $admin->admin_nama,
                        'admin_no_telp' => $admin->admin_no_telp,
                    ];
                }

                return [
                    'approval_id' => $approvalItem->approval_id,
                    'status' => 'decline',
                    'tugas' => [
                        'tugas_id' => $tugas->tugas_id,
                        'user_id' => $tugas->user_id,
                        'tugas_nama' => $tugas->tugas_nama,
                        'tugas_tipe' => $tugas->tugas_tipe,
                        'tugas_deskripsi' => $tugas->tugas_deskripsi,
                        'tugas_tenggat' => $tugas->tugas_tenggat,
                        'pemberi_tugas' => $pemberiTugas,
                    ],
                ];
            })->values(),
        ];

        return response()->json($result);
    }

}
