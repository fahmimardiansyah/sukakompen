<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiModel extends Model
{
    use HasFactory;

    protected $table = 't_kompetensi';      
    protected $primaryKey = 'kompetensi_id';  
    protected $fillable = ['jenis_id', 'kompetensi_kode', 'kompetensi_nama', 'kompetensi_deskrips'];

    public function jenis()
    {
        return $this->belongsTo(JenisModel::class, 'jenis_id', 'jenis_id');
    }
}
