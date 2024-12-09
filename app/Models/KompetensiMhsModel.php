<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiMhsModel extends Model
{
    use HasFactory;
    protected $table = 't_kompetensi_mahasiswa'; 
    protected $primaryKey = 'kompetensi_mahasiswa_id'; 

    protected $fillable = [
        'kompetensi_mahasiswa_id',
        'mahasiswa_id',
        'kompetensi_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    public function kompetensi()
    {
        return $this->belongsTo(KompetensiModel::class, 'kompetensi_id', 'kompetensi_id');
    }
}
