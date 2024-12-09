<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'm_prodi';
    protected $primaryKey = 'prodi_id';
    /** 
     * The atrributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = ['prodi_kode', 'prodi_nama'];
}
