<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class APIUploadFileMhsController extends Controller
{

    // msh upload file ketika tugas selesai
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'progress_id' => 'required|exists:t_progress,progress_id',
            'file_mahasiswa' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = ProgressModel::where('progress_id', $request->progress_id)->first();

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Progress ID tidak ditemukan'], 404);
        }

        if ($data->file_mahasiswa) {
            $oldFilePath = storage_path('app/public/posts/' . $data->file_mahasiswa);

            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if ($request->hasFile('file_mahasiswa')) {
            $file = $request->file('file_mahasiswa');
            
            $fileName = time() . '_' . $file->hashName();
            
            $file->storeAs('posts', $fileName, 'public');
            
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


    // pemberi tugas donlod file dari mhs
    public function download(Request $request)
    {
        $data = ProgressModel::where('progress_id', $request->progress_id)->first();

        if (!$data || !$data->file_mahasiswa) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        $filePath = storage_path('app/public/posts/' . $data->file_mahasiswa);

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File tidak ada di server'], 404);
        }

        return response()->download($filePath);
    }
}
