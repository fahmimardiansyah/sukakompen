<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use App\Models\TugasModel;
use App\Models\ApprovalModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\DosenModel;
use App\Models\TendikModel;
use App\Models\AdminModel;
use App\Models\ApplyModel;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\ProgressModel;
use Illuminate\Support\Carbon;


class APIDashboardMHSController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token tidak valid atau expired'], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'User tidak terautentikasi'], 401);
        }

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
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

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'tugas' => $tampil
        ]);
    }

}

