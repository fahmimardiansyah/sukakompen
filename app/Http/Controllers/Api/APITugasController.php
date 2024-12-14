<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use App\Models\ApprovalModel;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\DosenModel;
use App\Models\TendikModel;
use App\Models\AdminModel;
use App\Models\ApplyModel;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\ProgressModel;
use Illuminate\Support\Carbon;

class APITugasController extends Controller
{
    // untuk list tugas mahasiswa
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'error' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $currentDate = Carbon::now();

        $tugas = TugasModel::with('jenis', 'users') 
            ->whereNotIn('tugas_id', ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->where('tugas_tenggat', '>=', $currentDate)
            ->get();

        $progressCounts = ProgressModel::whereIn('tugas_id', $tugas->pluck('tugas_id'))
            ->groupBy('tugas_id')
            ->selectRaw('tugas_id, count(*) as progress_count')
            ->get()
            ->keyBy('tugas_id');

        $tampil = $tugas->filter(function($task) use ($progressCounts) {
            $progressCount = $progressCounts->get($task->tugas_id)->progress_count ?? 0;
            return $task->tugas_kuota > $progressCount;
        });

        $tampil->map(function ($task) {
            $pembuat_tugas = 'Unknown';
            if ($task->users) {
                $dosen = DosenModel::where('user_id', $task->users->user_id)->first();              
                $tendik = TendikModel::where('user_id', $task->users->user_id)->first();          
                $admin = AdminModel::where('user_id', $task->users->user_id)->first();

                if ($dosen) {
                    $pembuat_tugas = $dosen ? $dosen->dosen_nama : 'Unknown';
                } elseif ($tendik) {
                    $pembuat_tugas = $tendik ? $tendik->tendik_nama : 'Unknown';
                } elseif ($admin) {
                    $pembuat_tugas = $admin ? $admin->admin_nama : 'Unknown';
                }
            }

            $task->pembuat_tugas = $pembuat_tugas;

            return $task;
        });

        return response()->json($tampil);
    }

    public function show(Request $request)
    {
        $data = TugasModel::all()->where("tugas_id", $request->tugas_id)->first();
        return $data;
    }

    public function show_history(Request $request)
    {
        $data = TugasModel::all()->where("tugas_id", $request->tugas_id)->first();

        if (!$data) {
            return response()->json(['error' => 'Tugas not found'], 404);
        }

                $dosen = DosenModel::where('user_id', $data->user_id)->first(); 

                $tendik = TendikModel::where('user_id', $data->user_id)->first(); 

                $admin = AdminModel::where('user_id', $data->user_id)->first();

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
                    'tugas' => [
                        'tugas_id' => $data->tugas_id,
                        'user_id' => $data->user_id,
                        'tugas_nama' => $data->tugas_nama,
                        'tugas_tipe' => $data->tugas_tipe,
                        'jenis' => $data->jenis->jenis_nama,
                        'kompetensi' => $data->kompetensi->kompetensi_nama,
                        'tugas_deskripsi' => $data->tugas_deskripsi,
                        'tugas_tenggat' => $data->tugas_tenggat,
                        'jam' => $data->tugas_jam_kompen,
                        'pemberi_tugas' => $pemberiTugas,
                    ],
                ];
    }

    public function history(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan untuk user ini'], 404);
        }

        $apply = ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with(['tugas', 'tugas.users']) 
            ->get();

        $applyGrouped = $apply->groupBy('status');
        $applyAccepted = $applyGrouped->get(1, collect());

        $result = [
            'history' => $applyAccepted->map(function ($applyItem) {

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
                    'progress_id' => $applyItem->progress_id,
                    'status' => true,
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


