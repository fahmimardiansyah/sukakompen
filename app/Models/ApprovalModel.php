<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalModel extends Model
{
    use HasFactory;

    protected $table = 't_approval_tugas'; 
    protected $primaryKey = 'approval_id'; 

    protected $fillable = [
        'progress_id',
        'mahasiswa_id',
        'tugas_id',
        'status',
    ];

    public function progress()
    {
        return $this->belongsTo(ProgressModel::class, 'progress_id', 'progress_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    public function tugas()
    {
        return $this->belongsTo(TugasModel::class, 'tugas_id', 'tugas_id');
    }
}
