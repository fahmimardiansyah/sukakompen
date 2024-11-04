<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = 'task';          // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id';       // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['title', 'description', 'category', 'image', 'created_at', 'updated_at'];
    // Kolom yang bisa diisi

    /**
     * Contoh relasi jika ada relasi dengan model lain
     */
    // public function someRelation(): BelongsTo
    // {
    //     return $this->belongsTo(OtherModel::class, 'foreign_key', 'local_key');
    // }

    /**
     * Mendapatkan deskripsi singkat
     */
    public function getShortDescription(): string
    {
        return substr($this->description, 0, 50) . '...'; // Mengambil 50 karakter pertama dari deskripsi
    }

    /**
     * Mengambil kategori tugas
     */
    public function getCategory(): string
    {
        return $this->category;
    }
}
