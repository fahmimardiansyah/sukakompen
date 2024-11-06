<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class,'register']);
Route::post('register', [AuthController::class,'postregister']);


Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);


    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);              // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);          // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);       // menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);             // menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
        Route::get('/{id}', [UserController::class, 'show']);           // menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);     // menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']);         // menyiapkan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax 
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
        Route::delete('/{id}', [UserController::class, 'destroy']);     // menghapus data user
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']);
        Route::get('/level/create', [LevelController::class, 'create']);
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
        Route::post('/level', [LevelController::class, 'store']);
        Route::get('/level/{id}', [LevelController::class, 'show']);
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/level/{id}', [LevelController::class, 'update']);
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::delete('/level/{id}', [LevelController::class, 'destroy']);
    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', [KategoriController::class, 'index']);              // menampilkan halaman awal kategori
        Route::post('/list', [KategoriController::class, 'list']);          // menampilkan data kategori dalam bentuk json untuk datatables
        Route::get('/create', [KategoriController::class, 'create']);       // menampilkan halaman form tambah kategori
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah kategori Ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data kategori baru Ajax
        Route::post('/', [KategoriController::class, 'store']);             // menyimpan data kategori baru
        Route::get('/{id}', [KategoriController::class, 'show']);           // menampilkan detail kategori
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);     // menampilkan halaman form edit kategori
        Route::put('/{id}', [KategoriController::class, 'update']);         // menyiapkan perubahan data kategori
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit kategori Ajax 
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data kategori Ajax
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete kategori Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data kategori Ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy']);     // menghapus data kategori
    });
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);              // menampilkan halaman awal barang
        Route::post('/barang/list', [BarangController::class, 'list']);          // menampilkan data barang dalam bentuk json untuk datatables
        Route::get('/barang/create', [BarangController::class, 'create']);       // menampilkan halaman form tambah barang
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah barang Ajax
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data barang baru Ajax
        Route::post('/barang', [BarangController::class, 'store']);             // menyimpan data barang baru
        Route::get('/barang/{id}', [BarangController::class, 'show']);           // menampilkan detail barang
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);     // menampilkan halaman form edit barang
        Route::put('/barang/{id}', [BarangController::class, 'update']);         // menyiapkan perubahan data barang
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit barang Ajax 
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data barang Ajax
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete barang Ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data barang Ajax
        Route::delete('/barang/{id}', [BarangController::class, 'destroy']);     // menghapus data barang
        Route::get('/barang/import', [BarangController::class,'import']);
        Route::post('/barang/import_ajax', [BarangController::class,'import_ajax']);
        Route::get('/barang/export_excel', [BarangController::class,'export_excel']);
        Route::get('/barang/export_pdf', [BarangController::class,'export_pdf']);
    });
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']);              // menampilkan halaman awal supplier
        Route::post('/list', [SupplierController::class, 'list']);          // menampilkan data supplier dalam bentuk json untuk datatables
        Route::get('/create', [SupplierController::class, 'create']);       // menampilkan halaman form tambah supplier
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah supplier Ajax
        Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data supplier baru Ajax
        Route::post('/', [SupplierController::class, 'store']);             // menyimpan data supplier baru
        Route::get('/{id}', [SupplierController::class, 'show']);           // menampilkan detail supplier
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);     // menampilkan halaman form edit supplier
        Route::put('/{id}', [SupplierController::class, 'update']);         // menyiapkan perubahan data supplier
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit supplier Ajax 
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data supplier Ajax
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete supplier Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data supplier Ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']);     // menghapus data supplier
    });

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('upload_foto', [ProfileController::class, 'upload_foto'])->name('upload.foto');
});

// use App\Http\Controllers\KategoriController;
// use App\Http\Controllers\LevelController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\WelcomeController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', [WelcomeController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::put('user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::post('user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('user/ubah/{id}', [UserController::class, 'ubah']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);