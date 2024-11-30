<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\TendikModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTablesEditor;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; 

        $level = LevelModel::all(); 

        return view('admin.user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'level_id')
            ->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                if ($user->level_id === 1) { 
                    return $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/show_ajax') . '\')" class="btn btn-sm btn-info" title="Detail">
                        <i class="fas fa-info-circle"></i>
                    </button> ';
                }

                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/show_ajax') . '\')" class="btn btn-sm btn-info" title="Detail">
                        <i class="fas fa-info-circle"></i>
                    </button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit_ajax') . '\')" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete_ajax') . '\')" class="btn btn-sm btn-danger" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                    </button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // Ensure the 'aksi' column is rendered as raw HTML
            ->make(true);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('admin.user.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'password' => 'required|min:5'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), 
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('admin.user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:5|max:20'
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
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
                $check->update($request->all());
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

    public function confirm_ajax(String $id){
        $user = UserModel::find($id);

        return view('admin.user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $user = UserModel::find($id);
            if($user){
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $admin = null;
        $dosen = null;
        $tendik = null;
        $mahasiswa = null;

        if ($user->level_id == 1) {
            $admin = AdminModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 2) {
            $dosen = DosenModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 3) {
            $tendik = TendikModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 4) {
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
        }

        return view('admin.user.show_ajax', compact('user', 'admin', 'dosen', 'tendik', 'mahasiswa'));
    }

}
