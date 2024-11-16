<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        $id = session('user_id');
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'profile']
        ];
        $page = (object) [
            'title' => 'Profile Anda'
        ];
        $user = auth()->user();
        $activeMenu = 'profil'; // set menu yang sedang aktif
        $user = UserModel::with('level')->find($id);
        if ($user->foto === null) {
            $user->foto = 'default.png'; // Ganti dengan path foto default jika diperlukan
        }
        $level = LevelModel::all(); // ambil data level untuk filter level
        return view('profil.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('profil.edit_ajax', ['user' => $user, 'level' => $level]);
    }
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'nullable|integer',
                'username' => 'nullable|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'nullable|max:100',
                'password' => 'nullable|min:6|max:20',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('level_id')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('level_id');
                }
                if (!$request->filled('username')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('username');
                }
                if (!$request->filled('nama')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('nama');
                }
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update([
                    'username'  => $request->username,
                    'nama'      => $request->nama,
                    'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                    'level_id'  => $request->level_id,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function edit_foto(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('profil.edit_foto', ['user' => $user, 'level' => $level]);
    }
    public function update_foto(Request $request, $id)
    {
        // buat validasi ektensi dari filenya
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'foto'   => 'required|mimes:jpeg,png,jpg|max:4096'
            ];
            // ini buat nentuin mau ditaruh mana file yang diupload
            $folderPath = 'uploads/profile_pictures/' . auth()->user()->username . '/';

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            // Cek apakah user ditemukan berdasarkan ID
            $check = UserModel::find($id);
            if ($check) {
                // Cek apakah ada file foto yang diupload
                if ($request->hasFile('foto')) {
                    // Ambil file dari request
                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $path = 'image/profile/';

                    // Pindahkan file ke folder public/image/profile
                    $file->move(public_path($path), $filename);

                    // Update foto path di database
                    $check->update([
                        'foto' => $path . $filename
                    ]);

                    // Simpan path foto ke dalam session
                    session(['profile_img_path' => $path . $filename]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate'
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada file yang diupload'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }
}
