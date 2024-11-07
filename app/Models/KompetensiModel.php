<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiModel extends Model
{
    use HasFactory;

    protected $table = 't_kompetensi';  // Nama tabel dalam database
    protected $primaryKey = 'kompetensi_id';  // Primary key dari tabel
    public $incrementing = true;  // Menentukan bahwa primary key bertipe integer
    protected $keyType = 'int';   // Tipe dari primary key
    public $timestamps = true;    // Mengaktifkan timestamps

    protected $fillable = [
        'jenis_id',
        'kompetensi_kode',
        'kompetensi_nama',
        'kompetensi_deskripsi',
    ];

    // Relasi dengan JenisModel (Many-to-One)
    public function jenis()
    {
        return $this->belongsTo(JenisModel::class, 'jenis_id', 'jenis_id');
    }
}
