<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class APIDashboardMHSController extends Controller
{
    /**
     * Handle the dashboard data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Mendapatkan user berdasarkan ID yang login
        $user = UserModel::find($request->user()->user_id);

        // Data untuk rekomendasi tugas
        $rekomendasiTugas = TugasModel::select('tugas_nama', 'tugas_deskripsi', 'tugas_jam_kompen')
            ->orderBy('tugas_jam_kompen', 'desc') // Prioritaskan tugas dengan jam terbesar
            ->limit(3) // Batasi jumlah rekomendasi
            ->get();

        // Format data yang akan dikirim ke frontend
        $response = [
            'user' => [
                'nama' => $user->nama,
                'nim' => $user->username,
            ],
            'rekomendasi_tugas' => $rekomendasiTugas,
        ];

        return response()->json($response);
    }
}
