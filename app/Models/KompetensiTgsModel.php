<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiTgsModel extends Model
{
    use HasFactory;
    protected $table = 't_kompetensi_tugas'; 
    protected $primaryKey = 'kompetensi_tugas_id'; 

    protected $fillable = [
        'kompetensi_tugas_id',
        'tugas_id',
        'kompetensi_id',
    ];

    public function tugas()
    {
        return $this->belongsTo(TugasModel::class, 'tugas_id', 'tugas_id');
    }

    public function kompetensi()
    {
        return $this->belongsTo(KompetensiModel::class, 'kompetensi_id', 'kompetensi_id');
    }
}
