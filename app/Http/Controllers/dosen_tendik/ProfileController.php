<?php

namespace App\Http\Controllers\dosen_tendik;

use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\TendikModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Storage;
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

        $dosen = DosenModel::where('user_id', $userId)->first();

        $tendik = TendikModel::where('user_id', $userId)->first();

        $level = LevelModel::all(); 
        
        return view('dosen_tendik.profil.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user,'activeMenu' => $activeMenu, 'dosen' => $dosen, 'tendik' => $tendik]);
    }

    public function edit_username(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('dosen_tendik.profil.edit_username', ['user' => $user, 'level' => $level]);
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
        $dosen = DosenModel::where('user_id', $id)->first();

        $tendik = TendikModel::where('user_id', $id)->first();

        return view('dosen_tendik.profil.edit_profile', ['dosen' => $dosen, 'tendik' => $tendik]);
    }

    public function update_profile(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'dosen_nama' => 'sometimes|required|string|max:100',
                'dosen_no_telp' => 'sometimes|required|string|max:15',
                'dosen_email' => 'sometimes|required|string|max:100',
                'tendik_nama' => 'sometimes|required|string|max:100',
                'tendik_no_telp' => 'sometimes|required|string|max:15',
                'tendik_email' => 'sometimes|required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $dosen = DosenModel::where('user_id', $id)->first();
            $tendik = TendikModel::where('user_id', $id)->first();

            if ($dosen) {
                $dosen->update([
                    'dosen_nama' => $request->dosen_nama,
                    'dosen_no_telp' => $request->dosen_no_telp,
                    'dosen_email' =>$request->dosen_email
                ]);
            } elseif ($tendik) {
                $tendik->update([
                    'tendik_nama' => $request->tendik_nama,
                    'tendik_no_telp' => $request->tendik_no_telp,
                    'tendik_email' => $request->tendik_email,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        }

        return redirect('/');
    }

    public function edit_foto(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('dosen_tendik.profil.edit_foto', ['user' => $user, 'level'=>$level]);
    }

    public function update_foto(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'image' => 'required|mimes:jpeg,png,jpg|max:4096',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = UserModel::find($id);

            if ($check) {
                if ($request->hasFile('image')) {
                    $oldImagePath = basename($check->image);

                    if ($oldImagePath && Storage::disk('public')->exists('image/' . $oldImagePath)) {
                        Storage::disk('public')->delete('image/' . $oldImagePath);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . auth()->id() . "." . $extension;

                    $folderPath = 'image/';
                    $file->storeAs('public/' . $folderPath, $filename);

                    $check->update([
                        'image' => 'storage/' . $folderPath . $filename,
                    ]);

                    session(['profile_img_path' => 'storage/' . $folderPath . $filename]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diupdate',
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada file yang diupload',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/');
    }
}
