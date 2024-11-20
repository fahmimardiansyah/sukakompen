<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressModel;
use Illuminate\Support\Facades\Auth;

class APIKompenController extends Controller
{
    public function index()
    {
        // Pastikan pengguna terautentikasi
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Mendapatkan mahasiswa berdasarkan tugas yang dimiliki oleh pengguna yang login
        $mahasiswa = ProgressModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                // Memastikan tugas yang diambil hanya yang terkait dengan user yang sedang login
                $query->where('user_id', $user->user_id);
            })
            ->get();

        // Mengembalikan response dalam format JSON
        return response()->json($mahasiswa);
    }
}
