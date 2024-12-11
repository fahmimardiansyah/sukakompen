<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\KompetensiMhsModel;
use App\Models\KompetensiModel;
use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use App\Models\AlpaModel;
use App\Models\ProdiModel;
use App\Models\TendikModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTablesEditor;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $levelId = $request->query('level_id');
        $users = UserModel::select('user_id', 'username', 'level_id')
            ->with('level');

        if ($levelId) {
            $users->where('level_id', $levelId);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                if ($user->level_id === 1) { 
                    return '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-info-circle"></i>
                            </button>';
                }

                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-sm btn-info ml-1 mr-4" title="Detail">
                            <i class="fas fa-info-circle"></i>
                        </button>';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-sm btn-danger ml-4" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
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
                'password' => 'required|min:5',
                'nip' => 'required|string',
                'admin_nama' => 'required|string|max:100',
                'admin_no_telp' => 'required|string|max:15',
                'admin_email' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $message = 'Validasi gagal.';

                if ($errors->has('username')) {
                    $message = 'Username sudah dipakai, silakan gunakan username lain.';
                }

                return response()->json([
                    'status' => false,
                    'message' => $message,
                    'msgField' => $errors
                ]);
            }

            $user = UserModel::create([
                'level_id' => $request->level_id,
                'username' => $request->username,
                'password' => $request->password
            ]);

            AdminModel::create([
                'user_id' => $user->user_id,
                'nip' => $request->nip,
                'admin_nama' => $request->admin_nama,
                'admin_no_telp' => $request->admin_no_telp,
                'admin_email' => $request->admin_email
            ]);

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

        $dosen = DosenModel::where('user_id', $id)->first();

        $tendik = TendikModel::where('user_id', $id)->first();

        $mahasiswa = MahasiswaModel::where('user_id', $id)->first();
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();

        return view('admin.user.edit_ajax', ['user' => $user, 'level' => $level, 'dosen' => $dosen, 'tendik' => $tendik, 'mahasiswa' => $mahasiswa, 'prodi' => $prodi]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'password' => 'nullable|min:5|max:20',
                'nidn' => 'nullable|max:20',
                'nip' => 'nullable|max:20',
                'nim' => 'nullable|max:20',
                'dosen_nama' => 'nullable|max:100',
                'tendik_nama' => 'nullable|max:100',
                'mahasiswa_nama' => 'nullable|max:100',
                'dosen_no_telp' => 'nullable|max:15',
                'tendik_no_telp' => 'nullable|max:15',
                'prodi_id' => 'nullable|integer',
                'semester' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $message = 'Validasi gagal.';

                if ($errors->has('username')) {
                    $message = 'Username sudah dipakai, silakan gunakan username lain.';
                }

                return response()->json([
                    'status' => false,
                    'message' => $message,
                    'msgField' => $errors
                ]);
            }

            $user = UserModel::find($id);

            if ($user) {
                $data = $request->except(['password']);
                if ($request->filled('password')) {
                    $data['password'] = bcrypt($request->password);
                }

                $user->update($data);

                $dosen = DosenModel::where('user_id', $id);
                $tendik = TendikModel::where('user_id', $id);
                $mahasiswa = MahasiswaModel::where('user_id', $id);

                if ($request->filled('nidn')) {
                    $dosen->update([
                        'dosen_nama' => $request->dosen_nama,
                        'dosen_no_telp' => $request->dosen_no_telp
                    ]);
                } elseif ($request->filled('nip')) {
                    $tendik->update([
                        'tendik_nama' => $request->tendik_nama,
                        'tendik_no_telp' => $request->tendik_no_telp
                    ]);
                } elseif ($request->filled('nim')) {
                    $mahasiswa->update([
                        'mahasiswa_nama' => $request->mahasiswa_nama,
                        'prodi_id' => $request->prodi_id,
                        'semester' => $request->semester
                    ]);
                }

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
        $kompetensi = null;

        if ($user->level_id == 1) {
            $admin = AdminModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 2) {
            $dosen = DosenModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 3) {
            $tendik = TendikModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 4) {
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
            $kompetensi = KompetensiMhsModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->get();
        }

        return view('admin.user.confirm_ajax', ['user' => $user, 'admin' => $admin, 'dosen' => $dosen, 'tendik' => $tendik, 'mahasiswa' => $mahasiswa, 'kompetensi' => $kompetensi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);

            $dosen = DosenModel::where('user_id', $id)->first();
            $tendik = TendikModel::where('user_id', $id)->first();
            $mahasiswa = MahasiswaModel::where('user_id', $id)->first();

            DB::table('t_kompetensi_mahasiswa')->where('mahasiswa_id', $mahasiswa->mahasiswa_id)->delete();

            if ($user) {
                if ($dosen) {
                    $dosen->delete();
                } elseif ($tendik) {
                    $tendik->delete();
                } elseif ($mahasiswa) {
                    $mahasiswa->delete(); 
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ]);
                }

                $user->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
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
        $kompetensi = null;

        if ($user->level_id == 1) {
            $admin = AdminModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 2) {
            $dosen = DosenModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 3) {
            $tendik = TendikModel::where('user_id', $user->user_id)->first();
        } elseif ($user->level_id == 4) {
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
            $kompetensi = KompetensiMhsModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->get();
        }

        return view('admin.user.show_ajax', compact('user', 'admin', 'dosen', 'tendik', 'mahasiswa', 'kompetensi'));
    }

    public function importDosen()
    {
        return view('admin.user.import_dosen');
    }

    public function import_dosen(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_dosen' => [
                    'required', 
                    'mimes:xlsx', 
                    'max:51200'
                ]
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_dosen'); 

            $reader = IOFactory::createReader('Xlsx');  
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet(); 

            $data = $sheet->toArray(null, false, true, true); 

            if (count($data) > 1) { 
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $user = UserModel::create([
                            'level_id' => 2,
                            'username' => $value['D'],
                            'password' => '12345678'
                        ]);

                        DosenModel::create([
                            'user_id' => $user->user_id,
                            'nidn' => $value['A'],
                            'dosen_nama' => $value['B'],
                            'dosen_no_telp' => $value['C'],
                            'dosen_email' => $value['D'],
                            'created_at' => now(),
                        ]);
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function importTendik()
    {
        return view('admin.user.import_tendik');
    }

    public function import_tendik(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_tendik' => [
                    'required', 
                    'mimes:xlsx', 
                    'max:51200'
                ]
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_tendik'); 

            $reader = IOFactory::createReader('Xlsx');  
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet(); 

            $data = $sheet->toArray(null, false, true, true); 

            if (count($data) > 1) { 
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $user = UserModel::create([
                            'level_id' => 3,
                            'username' => $value['D'],
                            'password' => '12345678'
                        ]);

                        TendikModel::create([
                            'user_id' => $user->user_id,
                            'nip' => $value['A'],
                            'tendik_nama' => $value['B'],
                            'tendik_no_telp' => $value['C'],
                            'tendik_email' => $value['D'],
                            'created_at' => now(),
                        ]);
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function importMahasiswa()
    {
        return view('admin.user.import_mahasiswa');
    }

    public function import_mahasiswa(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_mahasiswa' => [
                    'required', 
                    'mimes:xlsx', 
                    'max:51200'
                ]
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_mahasiswa'); 

            $reader = IOFactory::createReader('Xlsx');  
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet(); 

            $data = $sheet->toArray(null, false, true, true); 

            if (count($data) > 1) { 
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $user = UserModel::create([
                            'level_id' => 4,
                            'username' => $value['A'],
                            'password' => '12345678'
                        ]);

                        MahasiswaModel::create([
                            'user_id' => $user->user_id,
                            'nim' => $value['A'],
                            'mahasiswa_nama' => $value['B'],
                            'prodi_id' => $value['C'],
                            'semester' => $value['D'],
                            'created_at' => now(),
                        ]);
                    }
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

}