<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisModel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis';  // Nama tabel dalam database
    protected $primaryKey = 'jenis_id';  // Primary key dari tabel
    public $incrementing = true;  // Menentukan bahwa primary key bertipe integer
    protected $keyType = 'int';   // Tipe dari primary key
    public $timestamps = true;    // Mengaktifkan timestamps

    protected $fillable = [
        'jenis_kode',
        'jenis_nama',
        'jenis_deskripsi',
    ];

    // Relasi dengan KompetensiModel (One-to-Many)
    public function kompetensi()
    {
        return $this->hasMany(KompetensiModel::class, 'jenis_id', 'jenis_id');
    }
}
