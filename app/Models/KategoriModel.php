<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class kategoriModel extends Model
{
    use HasFactory;

    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';
    /** 
     * The atrributes that are mass assignable.
     * 
     * @var array
     * 
     */
    protected $fillable = ['kategori_kode', 'kategori_nama'];

}

