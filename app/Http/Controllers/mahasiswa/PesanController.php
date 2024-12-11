<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ApplyModel;
use App\Models\ApprovalModel;
use App\Models\DosenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TendikModel;
use App\Models\MahasiswaModel;
use App\Models\AdminModel;
use App\Models\ProgressModel;
use Illuminate\Support\Carbon;

class PesanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Inbox Page',
            'list' => ['Home', 'Inbox']
        ];

        $activeMenu = 'inbox';

        $user = Auth::user();
        
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Mahasiswa tidak ditemukan');
        }

        $currentDate = Carbon::now();

        $apply = ApplyModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas')
            ->whereNotIn('tugas_id', ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->get();

        $approval = ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas')
            ->get();

        $progress = ProgressModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->whereNotIn('tugas_id', ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->pluck('tugas_id'))
            ->with(['tugas'])
            ->get();
        
        foreach ($progress as $item) {
            $item->tugas->tugas_tenggat >= $currentDate;
        }        

        foreach ($progress as $item) {
            $item->update(['status' => false]);
        }

        foreach ($apply as $item) {
            $item->pengguna = $this->getUserByUserId($item->tugas->user_id ?? null);
        }

        foreach ($approval as $item) {
            $item->pengguna = $this->getUserByUserId($item->tugas->user_id ?? null);
        }

        foreach ($progress as $item) {
            $item->pengguna = $this->getUserByUserId($item->tugas->user_id ?? null);
        }

        return view('mahasiswa.inbox.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'apply' => $apply,
            'approval' => $approval,
            'progress' => $progress,
        ]);
    }

    private function getUserByUserId($userId)
    {
        if (!$userId) {
            return null;
        }
        
        $models = [
            DosenModel::class,
            TendikModel::class,
            AdminModel::class
        ];

        foreach ($models as $model) {
            $user = $model::where('user_id', $userId)->first();
            if ($user) {
                return $user;
            }
        }

        return null;
    }

}
