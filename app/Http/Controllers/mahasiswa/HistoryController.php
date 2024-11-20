<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProgressModel;
use App\Models\MahasiswaModel;
use App\Models\TugasModel;
use App\Models\DosenModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Histori Tugas',
            'list' => ['Home', 'Histori']
        ];
        
        $activeMenu = 'history';

        $user = auth()->user();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        if (!$mahasiswa) {
            return redirect()->url('dashboardmhs')->with('error', 'Mahasiswa tidak ditemukan');
        }

        $mahasiswaId = $mahasiswa->mahasiswa_id;

        $history = ProgressModel::where('mahasiswa_id', $mahasiswaId)
                ->with('tugas')->get();

        return view('mahasiswa.history.index', ['history' => $history, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function export_pdf($tugas_id)
    {
        // Ambil data tugas berdasarkan tugas_id dan pilih kolom yang dibutuhkan
        $tugas = TugasModel::select('tugas_id', 'tugas_nama', 'tugas_jam_kompen', 'mahasiswa_id', 'dosen_id')
                           ->find($tugas_id);
    
        // Validasi jika tugas tidak ditemukan
        if (!$tugas) {
            abort(404, 'Tugas tidak ditemukan');
        }
    
        // Ambil data mahasiswa berdasarkan mahasiswa_id dan pilih kolom yang dibutuhkan
        $mahasiswa = MahasiswaModel::select('mahasiswa_nama', 'nim', 'semester')
                                   ->find($tugas->mahasiswa_id);
    
        // Ambil data dosen berdasarkan dosen_id dan pilih kolom yang dibutuhkan
        $dosen = DosenModel::select('dosen_nama', 'nidn')
                           ->find($tugas->dosen_id);
    
        // Validasi jika mahasiswa atau dosen tidak ditemukan
        if (!$mahasiswa || !$dosen) {
            abort(404, 'Data mahasiswa atau dosen tidak ditemukan');
        }
    
        // Load view PDF dengan data mahasiswa, dosen, dan tugas
        $pdf = Pdf::loadView('history.export_pdf', [
            'tugas' => $tugas,      // Kirimkan tugas ke view
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
        ]);
    
        // Set ukuran kertas dan orientasi
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
    
        // Stream file PDF ke browser
        return $pdf->stream('Form Kompensasi_' . $mahasiswa->mahasiswa_nama . '.pdf');
    }

}
