<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'mahasiswa_id';
    /** 
     * The atrributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = ['user_id', 'nim', 'mahasiswa_nama', 'jumlah_alpa', 'prodi_id', 'semester'];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id', 'prodi_id');
    }
}
