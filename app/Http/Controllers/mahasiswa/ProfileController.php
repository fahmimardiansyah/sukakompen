<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'profile']
        ];
        $page = (object) [
            'title' => 'Profile Anda'
        ];

        $userId = auth()->id();

        $activeMenu = 'profil'; 

        $user = UserModel::with('level')->find($userId);

        $mahasiswa = MahasiswaModel::where('user_id', $userId)->first();

        $level = LevelModel::all(); 
        
        return view('mahasiswa.profilemhs.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user,'activeMenu' => $activeMenu, 'mahasiswa' => $mahasiswa]);
    }

    public function edit_username(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('mahasiswa.profilemhs.edit_username', ['user' => $user, 'level' => $level]);
    }

    public function update_username(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|numeric',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'password' => 'nullable|min:6|max:20',
            ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = UserModel::find($id);

            if ($check) {
                $check->update([
                    'username'  => $request->username,
                    'password'  => $request->password ? bcrypt($request->password) : $check->password,
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

    public function edit_profile(string $id)
    {
        $mahasiswa = MahasiswaModel::where('user_id', $id)->first();

        return view('mahasiswa.profilemhs.edit_profile', ['mahasiswa' => $mahasiswa]);
    }

    public function update_profile(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mahasiswa_nama' => 'required|string|max:100',
            ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = MahasiswaModel::where('user_id', $id)->first();

            if ($check) {
                $check->update([
                    'mahasiswa_nama' => $request->mahasiswa_nama,
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
        return view('mahasiswa.profilemhs.edit_foto', ['user' => $user, 'level'=>$level]);
    }

    public function update_foto(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'image'   => 'required|mimes:jpeg,png,jpg|max:4096'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . auth()->user()->user_id . "." . $extension;

                    $folderPath = 'image/';
                    
                    $path = $file->storeAs('public/' . $folderPath, $filename);

                    $check->update([
                        'image' => 'storage/' . $folderPath . $filename
                    ]);

                    session(['profile_img_path' => 'storage/' . $folderPath . $filename]);

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
