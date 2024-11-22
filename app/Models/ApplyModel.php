<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyModel extends Model
{
    use HasFactory;

    protected $table = 't_apply'; 
    protected $primaryKey = 'apply_id'; 

    protected $fillable = [
        'mahasiswa_id',
        'tugas_id',
        'apply_status',
    ];

    protected $casts = [
        'apply_status' => 'boolean',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    public function tugas()
    {
        return $this->belongsTo(TugasModel::class, 'tugas_id', 'tugas_id');
    }
}
