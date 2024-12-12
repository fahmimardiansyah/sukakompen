<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class APIDownloadDosenController extends Controller
{
    public function download_tugas(Request $request)
    {
        $validated = $request->validate([
            'tugas_id' => 'required|integer',
        ]);

        $data = TugasModel::where('tugas_id', $validated['tugas_id'])->first();

        if (!$data || !$data->file_mahasiswa) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        $filePath = storage_path('app/public/posts/tugas/' . $data->file_mahasiswa);

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File tidak ada di server'], 404);
        }

        $mimeType = mime_content_type($filePath);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $data->file_mahasiswa . '"',
        ];

        return response()->file($filePath, $headers);
    }
}
