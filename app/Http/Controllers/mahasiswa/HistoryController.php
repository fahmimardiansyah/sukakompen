<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\ApprovalModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\TendikModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;

class HistoryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Histori Tugas',
            'list' => ['Home', 'Histori']
        ];

        $activeMenu = 'history';

        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Mahasiswa tidak ditemukan');
        }

        $history = ApprovalModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas')
            ->get();

        return view('mahasiswa.history.index', [
            'history' => $history,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }

    public function export_pdf($approval_id)
    {
        $user = Auth::user();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $approval = ApprovalModel::where('approval_id', $approval_id)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with([
                'tugas' => function ($query) {
                    $query->select('tugas_id', 'tugas_No', 'tugas_nama', 'tugas_jam_kompen', 'user_id');
                }
            ])
            ->first();

        if (!$approval || !$approval->tugas) {
            return redirect()
                ->route('history.index')
                ->with('error', 'Data tugas tidak ditemukan.');
        }

        $tugas = $approval->tugas;

        $admin = AdminModel::where('user_id', $tugas->user_id)->first();
        $dosen = DosenModel::where('user_id', $tugas->user_id)->first();
        $tendik = TendikModel::where('user_id', $tugas->user_id)->first();

        $pemberiTugas = null;
        $ni = null;

        if ($admin) {
            $pemberiTugas = $admin->admin_nama;
            $ni = $admin->nip;
        } elseif ($dosen) {
            $pemberiTugas = $dosen->dosen_nama;
            $ni = $dosen->nidn;
        } elseif ($tendik) {
            $pemberiTugas = $tendik->tendik_nama;
            $ni = $tendik->nip;
        }

        // Data untuk PDF
        $data = [
            'tugas_No' => $tugas->tugas_No ?? '-',
            'tugas_nama' => $tugas->tugas_nama ?? '-',
            'tugas_jam_kompen' => $tugas->tugas_jam_kompen ?? 0,
            'pemberi_tugas' => $pemberiTugas ?? '-',
            'nomor_induk' => $ni ?? '-',
            'mahasiswa_nama' => $mahasiswa->mahasiswa_nama ?? '-',
            'nim' => $mahasiswa->nim ?? '-',
            'semester' => $mahasiswa->semester ?? '-',
        ];

        // Membuat QR Code
        $qrContent = url( $approval_id . '/export_pdf');

        $result = Builder::create()
            ->data($qrContent)
            ->size(150)
            ->margin(10)
            ->build();

        $qrCode = base64_encode($result->getString());

        // Membuat PDF
        $pdf = Pdf::loadView('mahasiswa.history.export_pdf', [
            'tugas_No' => $data['tugas_No'],
            'pemberi_tugas' => $data['pemberi_tugas'],
            'nomor_induk' => $data['nomor_induk'],
            'mahasiswa_nama' => $data['mahasiswa_nama'],
            'nim' => $data['nim'],
            'semester' => $data['semester'],
            'tugas_nama' => $data['tugas_nama'],
            'tugas_jam_kompen' => $data['tugas_jam_kompen'],
            'qrCode' => $qrCode,
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);

        return $pdf->stream('Surat_Kompen_' . now()->format('Y-m-d_His') . '.pdf');
    }

}
