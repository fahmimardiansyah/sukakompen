<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

        $admin = AdminModel::where('user_id', $userId)->first();

        $level = LevelModel::all(); 
        
        return view('admin.profile.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user,'activeMenu' => $activeMenu, 'admin' => $admin]);
    }

    public function edit_username(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('admin.profile.edit_username', ['user' => $user, 'level' => $level]);
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
        $admin = AdminModel::where('user_id', $id)->first();

        return view('admin.profile.edit_profile', ['admin' => $admin]);
    }

    public function update_profile(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'admin_nama' => 'required|string|max:100',
                'admin_no_telp' => 'required|string|max:15',
                'admin_email' => 'required|string|max:100',
            ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = AdminModel::where('user_id', $id)->first();

            if ($check) {
                $check->update([
                    'admin_nama'  => $request->admin_nama,
                    'admin_no_telp'  => $request->admin_no_telp,
                    'admin_email' => $request->admin_email
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
        return view('admin.profile.edit_foto', ['user' => $user, 'level'=>$level]);
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
