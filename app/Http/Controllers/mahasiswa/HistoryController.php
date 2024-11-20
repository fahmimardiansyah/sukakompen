<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProgressModel;
use App\Models\MahasiswaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;

class HistoryController extends Controller
{
    /**
     * Menampilkan halaman histori tugas mahasiswa.
     */
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

        $history = ProgressModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with('tugas')
            ->get();

        return view('mahasiswa.history.index', [
            'history' => $history,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }

    /**
     * Mengekspor histori tugas mahasiswa ke dalam PDF.
     */
    public function export_pdf()
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()
                ->route('dashboardmhs')
                ->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $history = ProgressModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with([
                'tugas' => function ($query) {
                    $query->select('tugas_id', 'tugas_No', 'tugas_nama', 'tugas_jam_kompen', 'user_id')
                        ->with(['users' => function ($query) {
                            $query->select('user_id', 'nama');
                        }]);
                }
            ])
            ->get();

        $data = $history->map(function ($item) {
            return [
                'tugas_No' => $item->tugas->tugas_No ?? '-',
                'tugas_nama' => $item->tugas->tugas_nama ?? '-',
                'tugas_jam_kompen' => $item->tugas->tugas_jam_kompen ?? 0,
                'pemberi_tugas' => $item->tugas->users->nama ?? '-',
                'mahasiswa_nama' => $item->mahasiswa->mahasiswa_nama ?? '-',
                'nim' => $item->mahasiswa->nim ?? '-',
                'semester' => $item->mahasiswa->semester ?? '-',
            ];
        })->first();

        if (!$data) {
            return redirect()
                ->route('history.index')
                ->with('error', 'Tidak ada data yang dapat diekspor.');
        }

        // Generate QR Code using Endroid/qr-code
        $qrContent = url('/history/export_pdf');

        $result = Builder::create()
            ->data($qrContent)
            ->size(150)
            ->margin(10)
            ->build();

        $qrCode = base64_encode($result->getString());

        // Generate PDF
        $pdf = Pdf::loadView('mahasiswa.history.export_pdf', [
            'tugas_No' => $data['tugas_No'],
            'pemberi_tugas' => $data['pemberi_tugas'],
            'nidn' => '123456', // Sesuaikan dengan data yang tersedia
            'mahasiswa_nama' => $data['mahasiswa_nama'],
            'nim' => $data['nim'],
            'semester' => $data['semester'],
            'tugas_nama' => $data['tugas_nama'],
            'tugas_jam_kompen' => $data['tugas_jam_kompen'],
            'qrCode' => $qrCode, // Kirim QR Code dalam format base64
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);

        return $pdf->stream('Surat_Kompen_' . now()->format('Y-m-d_His') . '.pdf');
    }
}
