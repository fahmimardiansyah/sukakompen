<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\JenisModel;
use App\Models\KompetensiModel;
use App\Models\MahasiswaModel;
use App\Models\ProgressModel;
use Illuminate\Support\Facades\Auth;
use App\Models\TugasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Tugas Page',
            'list' => ['Home', 'Tugas']
        ];

        $activeMenu = 'kompen';

        $user = Auth::user();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Mahasiswa tidak ditemukan');
        }

        $tugas = TugasModel::with('jenis')
            ->whereNotIn('tugas_id', ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->get();

        return view('mahasiswa.task.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'tugas' => $tugas,
        ]);
    }

    public function show()
    {
        $breadcrumb = (object) [
            'title' => 'Tugas Page',
            'list' => ['Home', 'Tugas', 'detail']
        ];

        return view('mahasiswa.task.detail', ['breadcrumb' => $breadcrumb]);
    }

    public function detail($id)
    {
        $description = TugasModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Tugas',
            'list' => ['Home', 'Tugas', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Tugas'
        ];

        $activeMenu = 'tugas'; 

        return view('mahasiswa.task.detail', ['description' => $description, 'activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb, 'page' => $page]);
    }

    public function apply($id)
    {
        $tugas = TugasModel::where('tugas_id', $id)->first();

        return view('mahasiswa.task.apply', ['tugas' => $tugas]);
    }

    public function apply_tugas(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $tugas = TugasModel::findOrFail($id);

                $user = auth()->user();

                $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

                $alreadyApplied = ApplyModel::where('tugas_id', $tugas->tugas_id)
                    ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                    ->exists();

                if ($alreadyApplied) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Anda sudah mendaftar untuk tugas ini.'
                    ], 400);
                }

                ApplyModel::create([
                    'tugas_id' => $tugas->tugas_id,
                    'mahasiswa_id' => $mahasiswa->mahasiswa_id
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Pendaftaran tugas berhasil.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Permintaan tidak valid.'
        ], 400);
    }
    
}
