<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TendikModel extends Model
{
    use HasFactory;

    protected $table = 'm_tendik';

    protected $primaryKey = 'tendik_id'; 

    protected $fillable = [
        'user_id',
        'nip',
        'tendik_nama',
        'tendik_no_telp',
        'tendik_email'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
