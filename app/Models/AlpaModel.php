<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlpaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa_alpa'; 
    protected $primaryKey = 'alpa_id'; 

    protected $fillable = [
        'mahasiswa_alpa_nim',
        'mahasiswa_alpa_nama',
        'progress_id',
        'jam_alpa',
    ];

    public function progress()
    {
        return $this->belongsTo(ProgressModel::class, 'progress_id', 'progress_id');
    }
}
