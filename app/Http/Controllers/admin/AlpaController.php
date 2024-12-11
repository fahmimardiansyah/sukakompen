<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlpaModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\PDF;

class AlpaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Alpa Mahasiswa Page',
            'list' => ['Home', 'Alpa Mahasiswa']
        ];

        $activeMenu = 'alpam';

        $mahasiswa = AlpaModel::all();

        return view('admin.alpam.index', [
            'mahasiswa' => $mahasiswa,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }

    public function import()
    {
        return view('admin.alpam.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_alpa' => [
                    'required', 
                    'mimes:xlsx', 
                    'max:51200'
                ]
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_alpa'); 

            $reader = IOFactory::createReader('Xlsx');  
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet(); 

            $data = $sheet->toArray(null, false, true, true); 

            if (count($data) > 1) { 
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { 
                        $existing = AlpaModel::where('mahasiswa_alpa_nim', $value['A'])
                                            ->where('mahasiswa_alpa_nama', $value['B'])
                                            ->first();

                        $existingMahasiswa = MahasiswaModel::where('nim', $value['A'])
                                            ->where('mahasiswa_nama', $value['B'])
                                            ->first();

                        if ($existing) {
                            $existing->increment('jam_alpa', $value['C']);
                            $existingMahasiswa->increment('jumlah_alpa', $value['C']);
                        } else {
                            AlpaModel::create([
                                'mahasiswa_alpa_nim' => $value['A'],
                                'mahasiswa_alpa_nama' => $value['B'],
                                'jam_alpa' => $value['C'],
                                'created_at' => now(),
                            ]);
                        }
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
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
