<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use App\Models\AlpaModel;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use App\Models\KompetensiMhsModel;
use App\Models\MahasiswaModel;
use App\Models\ProgressModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PesanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pesan Page',
            'list' => ['Home', 'Pesan Tugas']
        ];

        $activeMenu = 'notif';

        $user = Auth::user();
        
        $data = TugasModel::where('user_id', $user->user_id)->get();

        if ($data->isEmpty()) {
            $apply = [];
            $approval = [];
            $progress = [];
        
            $message = 'Tidak ada data tugas terkait.';
        
            return view('dosen_tendik.notif.index', [
                'breadcrumb' => $breadcrumb, 
                'activeMenu' => $activeMenu, 
                'apply' => $apply, 
                'approval' => $approval,
                'progress' => $progress,
                'message' => $message 
            ]);
        }
        

        $apply = ApplyModel::whereIn('tugas_id', $data->pluck('tugas_id'))
            ->with('mahasiswa')
            ->get();

        $approval = ApprovalModel::whereIn('tugas_id', $data->pluck('tugas_id'))
            ->with('mahasiswa')
            ->get();

        $currentDate = Carbon::now();

        $progress = ProgressModel::whereIn('tugas_id', $data->pluck('tugas_id'))
            ->with(['tugas', 'mahasiswa'])
            ->get();
        
        foreach ($progress as $item) {
            if ($item->tugas->tugas_tenggat < $currentDate && $item->status !== 1) {
                $item->update(['status' => false]); 
            }
        }

        return view('dosen_tendik.notif.index', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'apply' => $apply, 
            'approval' => $approval,
            'progress' => $progress
        ]);
    }

    public function apply($id)
    {
        $apply = ApplyModel::where('apply_id', $id)->first();
        $kompetensi = KompetensiMhsModel::where('mahasiswa_id', $apply->mahasiswa->mahasiswa_id)->get();

        return view('dosen_tendik.notif.show_ajax', ['apply' => $apply, 'kompetensi' => $kompetensi]);
    }

    public function acc(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $apply = ApplyModel::find($id);
            
            $progress = ProgressModel::whereIn('tugas_id', [$apply->tugas_id])
                ->groupBy('tugas_id')
                ->selectRaw('tugas_id, count(*) as progress_count')
                ->get()
                ->keyBy('tugas_id');

            $progressCount = $progress->get($apply->tugas_id)->progress_count ?? 0;

            if ($apply->tugas->tugas_kuota <= $progressCount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kuota sudah penuh'
                ]);
            }

            ProgressModel::create([
                'apply_id' => $apply->apply_id,
                'tugas_id' => $apply->tugas_id,
                'mahasiswa_id' => $apply->mahasiswa_id,
            ]);

            if ($apply) {
                $apply->update([
                    'apply_status' => true
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Apply Diterima'
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

    public function decline(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $apply = ApplyModel::find($id);

            if ($apply) {
                $apply->update([
                    'apply_status' => false
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Apply Ditolak'
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

    public function tugas($id)
    {
        $approve = ApprovalModel::where('approval_id', $id)->first();

        $fileTugas = null;
        if ($approve && $approve->progress->file_mahasiswa) {
            $filePath = asset('storage/posts/pengumpulan/' . $approve->progress->file_mahasiswa);
            $fileName = basename($approve->progress->file_mahasiswa);
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

        return view('dosen_tendik.notif.acc_ajax', ['approve' => $approve, 'fileTugas' => $fileTugas]);
    }

    public function acc_tugas(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $approval = ApprovalModel::find($id);

            if (!$approval) {
                return response()->json([
                    'status' => false,
                    'message' => 'Approval tidak ditemukan'
                ]);
            }

            $mahasiswa = MahasiswaModel::find($approval->mahasiswa_id);

            if (!$mahasiswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Mahasiswa tidak ditemukan'
                ]);
            }

            $alpa = AlpaModel::where('mahasiswa_alpa_nim', $mahasiswa->nim)->first();

            // Update approval status
            $approval->update([
                'status' => true
            ]);

            // Update mahasiswa's jumlah_alpa
            $mahasiswa->update([
                'jumlah_alpa' => ($mahasiswa->jumlah_alpa - $approval->tugas->tugas_jam_kompen)
            ]);

            // Update jam_kompen only if $alpa exists
            if ($alpa) {
                $alpa->update([
                    'jam_kompen' => ($alpa->jam_kompen + $approval->tugas->tugas_jam_kompen)
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Tugas Diterima'
            ]);
        }

        return redirect('/');
    }

    public function decline_tugas(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $approval = ApprovalModel::find($id);

            if ($approval) {
                $approval->update([
                    'status' => false
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Tugas Ditolak'
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