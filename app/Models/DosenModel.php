<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = 'm_dosen';

    protected $primaryKey = 'dosen_id'; 

    protected $fillable = [
        'user_id',
        'nidn',
        'dosen_nama',
        'dosen_no_telp',
        'dosen_email', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
