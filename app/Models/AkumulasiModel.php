<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkumulasiModel extends Model
{
    use HasFactory;

    protected $table = 't_akumulasi'; 
    protected $primaryKey = 'akumulasi_id'; 

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'jumlah_alpa',
    ];

    public function progress()
    {
        return $this->belongsTo(ProgressModel::class, 'progress_id', 'progress_id');
    }
}
