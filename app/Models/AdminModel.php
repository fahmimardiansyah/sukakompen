<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'm_admin';

    protected $primaryKey = 'admin_id'; 

    protected $fillable = [
        'user_id',
        'nip',
        'admin_nama',
        'admin_no_telp',
        'admin_email'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
