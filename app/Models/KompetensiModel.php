<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiModel extends Model
{
    use HasFactory;

    protected $table = 't_kompetensi';      
    protected $primaryKey = 'kompetensi_id';  
    protected $fillable = ['kompetensi_kode', 'kompetensi_nama', 'kompetensi_deskrips'];
}
