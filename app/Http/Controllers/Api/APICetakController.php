<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\ApprovalModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\TendikModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Endroid\QrCode\Builder\Builder;

class APICetakController extends Controller
{
    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        $approval = ApprovalModel::where('approval_id', $request->approval_id)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->with([
                'tugas' => function ($query) {
                    $query->select('tugas_id', 'tugas_No', 'tugas_nama', 'tugas_jam_kompen', 'user_id');
                }
            ])
            ->first();

        if (!$approval) {
            return response()->json(['error' => 'Approval not found'], 404);
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

        $qrContent = url( $request->approval_id . '/export_pdf');

        $result = Builder::create()
            ->data($qrContent)
            ->size(150)
            ->margin(10)
            ->build();

        $qrCode = base64_encode($result->getString());

        $data = [
            'pemberi_tugas' => $pemberiTugas ?? '-',
            'nip_pemberi' => $ni ?? '-',
            'nama_mahasiswa' => $mahasiswa->mahasiswa_nama ?? '-',
            'nim' => $mahasiswa->nim ?? '-',
            'semester' => $mahasiswa->semester ?? '-',
            'pekerjaan' => $tugas->tugas_nama ?? '-',
            'jumlah_jam' => $tugas->tugas_jam_kompen ?? 0,
            'tanggal' => now()->format('d F Y'),
            'qrCode' => $qrCode,
        ];

        return response()->json($data, 200);
    }
}
