<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class JenisModel
{
    use HasFactory;

    protected $table = 'm_jenis';       
    protected $primaryKey = 'jenis_id';     protected $fillable = ['jenis_kode', 'jenis_nama', 'jenis_deskrips'];
}