<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApprovalModel;
use App\Models\ProgressModel;

class KompenMhsController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Kompen Mahasiswa Page',
            'list' => ['Home', 'Kompen Mahasiswa']
        ];

        $activeMenu = 'kompenma';
        $user = auth()->user();

        $currentYear = now()->year;
        $selectedYear = $request->input('tahun', $currentYear);

        $startDate = now()->subYears(5)->startOfYear();
        $endDate = now()->endOfYear();

        $approval = ApprovalModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->whereRaw('YEAR(updated_at) = ?', [$selectedYear])
            ->orderBy('updated_at', 'desc') 
            ->get();

        $progress = ProgressModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->whereRaw('YEAR(updated_at) = ?', [$selectedYear])
            ->orderBy('updated_at', 'desc')
            ->get();

        $approvalAll = ApprovalModel::with(['tugas', 'mahasiswa'])
            ->whereRaw('YEAR(updated_at) = ?', [$selectedYear])
            ->orderBy('updated_at', 'desc') 
            ->get();

        $progressAll = ProgressModel::with(['tugas', 'mahasiswa'])
            ->whereRaw('YEAR(updated_at) = ?', [$selectedYear])
            ->orderBy('updated_at', 'desc') 
            ->get();

        $years = range($startDate->year, $endDate->year);

        return view('admin.kompenma.index', [
            'mahasiswa' => $approval,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'progress' => $progress,
            'approvalAll' => $approvalAll,
            'progressAll' => $progressAll,
            'years' => $years,
            'selectedYear' => $selectedYear
        ]);
    }

}