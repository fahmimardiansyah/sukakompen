<?php

namespace App\Http\Controllers;

use App\Models\TaskModel; // Masih menggunakan model TaskModel
use Illuminate\Http\Request;

class DeskripsiController extends Controller
{
    /**
     * Menampilkan daftar semua deskripsi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $descriptions = TaskModel::all(); // Mengambil semua data deskripsi
        return view('descriptions.index', compact('descriptions')); // Mengembalikan tampilan dengan data deskripsi
    }

    /**
     * Menampilkan formulir untuk membuat deskripsi baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('descriptions.create'); // Mengembalikan tampilan untuk membuat deskripsi baru
    }

    /**
     * Menyimpan deskripsi baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'nullable|string|max:255',
        ]);

        // Membuat deskripsi baru
        TaskModel::create($request->all());

        // Redirect setelah sukses
        return redirect()->route('descriptions.index')->with('success', 'Deskripsi berhasil ditambahkan!');
    }

    /**
     * Menampilkan rincian deskripsi tertentu.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $description = TaskModel::findOrFail($id); // Mengambil deskripsi berdasarkan ID
        return view('descriptions.show', compact('description')); // Mengembalikan tampilan untuk menunjukkan deskripsi
    }

    /**
     * Menampilkan formulir untuk mengedit deskripsi tertentu.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $description = TaskModel::findOrFail($id); // Mengambil deskripsi berdasarkan ID
        return view('descriptions.edit', compact('description')); // Mengembalikan tampilan untuk mengedit deskripsi
    }

    /**
     * Memperbarui deskripsi tertentu di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'image' => 'nullable|string|max:255',
        ]);

        // Mengambil deskripsi yang akan diperbarui
        $description = TaskModel::findOrFail($id);
        $description->update($request->all()); // Memperbarui deskripsi dengan data baru

        // Redirect setelah sukses
        return redirect()->route('descriptions.index')->with('success', 'Deskripsi berhasil diperbarui!');
    }

    /**
     * Menghapus deskripsi tertentu dari database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $description = TaskModel::findOrFail($id); // Mengambil deskripsi berdasarkan ID
        $description->delete(); // Menghapus deskripsi

        // Redirect setelah sukses
        return redirect()->route('descriptions.index')->with('success', 'Deskripsi berhasil dihapus!');
    }
}
