<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class APIDownloadDosenController extends Controller
{
    public function download_tugas(Request $request)
    {
        $validated = $request->validate([
            'tugas_id' => 'required|integer',
        ]);

        $data = TugasModel::where('tugas_id', $validated['tugas_id'])->first();

        if (!$data || !$data->file_tugas) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        $filePath = storage_path('app/public/posts/tugas/' . $data->file_tugas);

        if (!File::exists($filePath)) {
            return response()->json(['message' => 'File tidak ada di server'], 404);
        }

        $mimeType = File::mimeType($filePath);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . basename($data->file_tugas) . '"',
        ];

        return response()->file($filePath, $headers);
    }
}
