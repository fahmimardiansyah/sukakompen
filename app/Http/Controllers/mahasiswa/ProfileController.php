<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $id = session('user_id');

        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'profile']
        ];

        $page = (object) [
            'title' => 'profile Anda'
        ];

        $user = auth()->user();

        $activeMenu = 'profilemhs';

        $user = UserModel::with('level')->find($id);

        if ($user->foto === null) {
            $user->foto = 'default.png';
        }

        $level = LevelModel::all();

        return view('mahasiswa.profilemhs.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'user';
        
        return view('mahasiswa.user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        
        return view('mahasiswa.profilemhs.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'nullable|integer',
                'username' => 'nullable|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'nullable|max:100',
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
                if (!$request->filled('level_id')) { 
                    $request->request->remove('level_id');
                }
                if (!$request->filled('username')) { 
                    $request->request->remove('username');
                }
                if (!$request->filled('nama')) { 
                    $request->request->remove('nama');
                }
                if (!$request->filled('password')) { 
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
        
        return view('mahasiswa.profilemhs.edit_foto', ['user' => $user, 'level' => $level]);
    }

    public function update_foto(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'foto'   => 'required|mimes:jpeg,png,jpg|max:4096'
            ];

            $folderPath = 'uploads/profile_pictures/' . auth()->user()->username . '/';

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

                if ($request->hasFile('foto')) {

                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $path = 'image/profile/';

                    $file->move(public_path($path), $filename);

                    $check->update([
                        'foto' => $path . $filename
                    ]);

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
