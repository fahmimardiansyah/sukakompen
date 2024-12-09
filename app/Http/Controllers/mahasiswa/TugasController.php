<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
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
use Illuminate\Support\Facades\Storage;
use Laravel\Prompts\Progress;

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

    public function upload($id)
    {
        $description = ProgressModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Tugas',
            'list' => ['Home', 'Tugas', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Tugas'
        ];

        $activeMenu = 'tugas'; 

        $fileData = null;
        if ($description && $description->tugas->file_tugas) {
            $filePath = asset('storage/posts/tugas/' . $description->tugas->file_tugas);
            $fileName = explode('_', $description->file_tugas, 2)[1] ?? $description->file_tugas;
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $icons = [
                'pdf' => 'fas fa-file-pdf',
                'doc' => 'fas fa-file-word',
                'docx' => 'fas fa-file-word',
                'xls' => 'fas fa-file-excel',
                'xlsx' => 'fas fa-file-excel',
                'ppt' => 'fas fa-file-powerpoint',
                'pptx' => 'fas fa-file-powerpoint',
                'zip' => 'fas fa-file-archive',
                'rar' => 'fas fa-file-archive',
                'default' => 'fas fa-file',
            ];
            $iconClass = $icons[$fileExtension] ?? $icons['default'];

            $fileData = [
                'path' => $filePath,
                'name' => $fileName,
                'icon' => $iconClass,
            ];
        }

        $fileTugas = null;
        if ($description && $description->file_mahasiswa) {
            $fileTugasPath = asset('storage/posts/pengumpulan/' . $description->file_mahasiswa);
            $fileTugasName = explode('_', $description->file_tugas, 2)[1] ?? $description->file_mahasiswa;
            $fileTugasExtension = pathinfo($fileTugasName, PATHINFO_EXTENSION);
            $icons = [
                'pdf' => 'fas fa-file-pdf',
                'doc' => 'fas fa-file-word',
                'docx' => 'fas fa-file-word',
                'xls' => 'fas fa-file-excel',
                'xlsx' => 'fas fa-file-excel',
                'ppt' => 'fas fa-file-powerpoint',
                'pptx' => 'fas fa-file-powerpoint',
                'zip' => 'fas fa-file-archive',
                'rar' => 'fas fa-file-archive',
                'default' => 'fas fa-file',
            ];
            $iconClass = $icons[$fileTugasExtension] ?? $icons['default'];

            $fileTugas = [
                'path' => $fileTugasPath,
                'name' => $fileTugasName,
                'icon' => $iconClass,
            ];
        }

        return view('mahasiswa.task.upload', ['description' => $description, 'activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb, 'page' => $page, 'fileData' => $fileData, 'fileTugas' => $fileTugas]);
    }

    public function upload_tugas($id) {
        $progress = ProgressModel::where('progress_id', $id)->first();

        return view('mahasiswa.task.upload_tugas', ['progress' => $progress]);
    }

    public function upload_file(Request $request, $id) 
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_mahasiswa' => ['required', 'file', 'mimes:doc,docx,pdf,ppt,pptx,xls,xlsx,zip,rar', 'max:2048'],
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $progress = ProgressModel::find($id);

            if ($progress) {
                try {
                    $data = $request->except('file_mahasiswa');

                    if ($request->hasFile('file_mahasiswa')) {
                        $file = $request->file('file_mahasiswa');
                        $filename = time() . '_' .  $file->getClientOriginalName();
                        $file->storeAs('posts/pengumpulan', $filename, 'public');

                        if ($progress->file_mahasiswa && Storage::disk('public')->exists('posts/pengumpulan/' . $progress->file_mahasiswa)) {
                            Storage::disk('public')->delete('posts/pengumpulan/' . $progress->file_mahasiswa);
                        }

                        $data['file_mahasiswa'] = $filename;
                    }

                    $progress->update(
                        $data
                    );

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage(),
                        'trace' => $e->getTraceAsString(), 
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    }

    public function kirim($id)
    {
        $progress = ProgressModel::where('progress_id', $id)->first();

        $fileTugas = null;
        if ($progress && $progress->file_mahasiswa) {
            $filePath = asset('storage/posts/pengumpulan/' . $progress->file_mahasiswa);
            $fileName = basename($progress->file_mahasiswa);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $icons = [
                'pdf' => 'fas fa-file-pdf',
                'doc' => 'fas fa-file-word',
                'docx' => 'fas fa-file-word',
                'xls' => 'fas fa-file-excel',
                'xlsx' => 'fas fa-file-excel',
                'ppt' => 'fas fa-file-powerpoint',
                'pptx' => 'fas fa-file-powerpoint',
                'zip' => 'fas fa-file-archive',
                'rar' => 'fas fa-file-archive',
                'default' => 'fas fa-file',
            ];
            $iconClass = $icons[$fileExtension] ?? $icons['default'];

            $fileTugas = [
                'path' => $filePath,
                'name' => $fileName,
                'icon' => $iconClass,
            ];
        }

        return view('mahasiswa.task.kirim', ['progress' => $progress, 'fileTugas' => $fileTugas]);
    }

    public function kirim_tugas(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {

            $progress = ProgressModel::find($id);

            ApprovalModel::create([
                'progress_id' => $progress->progress_id,
                'tugas_id' => $progress->tugas_id,
                'mahasiswa_id' => $progress->mahasiswa_id,
            ]);

            if ($progress) {
                $progress->update([
                    'status' => true
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Tugas Terkirim'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    
}
