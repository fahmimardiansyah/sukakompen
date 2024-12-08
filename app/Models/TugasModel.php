<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasModel extends Model
{
    use HasFactory;

    protected $table = 't_tugas';
    protected $primaryKey = 'tugas_id'; 
    protected $fillable = [
        'tugas_No', 'tugas_nama', 'jenis_id', 'tugas_tipe', 'tugas_deskripsi', 
        'tugas_kuota', 'tugas_jam_kompen', 'tugas_tenggat', 'kompetensi_id', 'user_id', 'file_tugas'
    ];

    const TIPE_ENUM = ['Online', 'Offline'];

    protected $casts = [
        'tugas_tenggat' => 'datetime',
    ];    

    public function users() : BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }


    public function jenis() : BelongsTo
    {
        return $this->belongsTo(JenisModel::class, 'jenis_id', 'jenis_id');
    }

    public function kompetensi() : BelongsTo
    {
        return $this->belongsTo(KompetensiModel::class, 'kompetensi_id', 'kompetensi_id');
    }
}
