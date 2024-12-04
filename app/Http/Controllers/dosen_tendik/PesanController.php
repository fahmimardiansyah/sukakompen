<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use App\Models\ProgressModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // Fetch a collection of TugasModel where user_id matches the logged-in user's user_id
        $data = TugasModel::where('user_id', $user->user_id)->get();

        if ($data->isEmpty()) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Data tidak ditemukan');
        }

        // Fetch ApplyModel and ApprovalModel records for each tugas_id in the collection
        $apply = ApplyModel::whereIn('tugas_id', $data->pluck('tugas_id'))
            ->with('mahasiswa')
            ->get();

        $approval = ApprovalModel::whereIn('tugas_id', $data->pluck('tugas_id'))
            ->with('mahasiswa')
            ->get();

        return view('dosen_tendik.notif.index', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'apply' => $apply, 
            'approval' => $approval
        ]);
    }

    public function apply($id)
    {
        $apply = ApplyModel::where('apply_id', $id)->first();

        return view('dosen_tendik.notif.show_ajax', ['apply' => $apply]);
    }

    public function acc(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $apply = ApplyModel::find($id);

            ProgressModel::create([
                'apply_id' => $apply->apply_id,
                'tugas_id' => $apply->tugas_id,
                'mahasiswa_id' => $apply->mahasiswa_id,
                'status' => false,
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
                    'message' => 'Data Ditolak'
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

    public function tugas()
    {
        return view('admin.pesan.acc_ajax');
    }
}
