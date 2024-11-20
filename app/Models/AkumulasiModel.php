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

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}
