<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class APIFileTugasMHSController extends Controller
{
    // mahasiswa upload file tugas
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_mahasiswa' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = ProgressModel::where('apply_id', $request->apply_id)->first();

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Progress ID tidak ditemukan'], 404);
        }

        if ($data->file_mahasiswa) {
            $oldFilePath = storage_path('app/public/posts/pengumpulan/' . $data->file_mahasiswa);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if ($request->hasFile('file_mahasiswa')) {
            $file = $request->file('file_mahasiswa');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('posts/pengumpulan', $fileName, 'public');

            $data->file_mahasiswa = $fileName;
            $data->save();

            return response()->json([
                'status' => true,
                'message' => 'File berhasil diupload',
                'file_name' => $fileName
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Gagal mengupload file'], 500);
    }

    public function download(Request $request)
    {
        $validated = $request->validate([
            'progress_id' => 'required|integer',
        ]);

        $data = ProgressModel::where('progress_id', $validated['progress_id'])->first();

        if (!$data || !$data->file_mahasiswa) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        $filePath = storage_path('app/public/posts/pengumpulan/' . $data->file_mahasiswa);

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
