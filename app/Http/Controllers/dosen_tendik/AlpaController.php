<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlpaModel;
use Barryvdh\DomPDF\Facade\Pdf;

class AlpaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Alpa Mahasiswa Page',
            'list' => ['Home', 'Alpa Mahasiswa']
        ];

        $activeMenu = 'alpha';

        $mahasiswa = AlpaModel::all();

        return view('dosen_tendik.alpha.index', [
            'mahasiswa' => $mahasiswa,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }

    public function export_pdf() {
        $mahasiswa = AlpaModel::select('mahasiswa_alpa_nim', 'mahasiswa_alpa_nama', 'jam_kompen', 'jam_alpa')
                ->orderBy('mahasiswa_alpa_nim')
                ->get();

        $pdf = Pdf::loadView('admin.alpam.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait'); 
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Alpa Mahasiswa '.date('Y-m-d H:i:s').'.pdf');
    }
}
