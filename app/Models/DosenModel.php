<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = 'm_dosen';

    protected $fillable = [
        'dosen_nama',
        'nidn',
        'username',
        'no_telp',
        'tugas_id',
    ];

    public function tugas()
    {
        return $this->belongsTo(TugasModel::class, 'tugas_id');
    }
}
