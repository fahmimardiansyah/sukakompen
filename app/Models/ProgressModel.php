<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProgressModel extends Model
{
    use HasFactory;

    protected $table = 't_progress'; 
    protected $primaryKey = 'progress_id'; 

    protected $fillable = [
        'apply_id',
        'mahasiswa_id',
        'tugas_id',
        'file_mahasiswa',
        'status',
    ];

    protected function file(): Attribute {
        return Attribute::make(
            get: fn ($file) => url('/storage/posts/' . $file),
        );
    }

    public function apply()
    {
        return $this->belongsTo(ApplyModel::class, 'apply_id', 'apply_id');
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
