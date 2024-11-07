<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TugasModel extends Model
{
    use HasFactory;

    protected $table = 't_tugas';  // Table name

    protected $primaryKey = 'tugas_id';  // Primary key

    public $incrementing = true;  // Primary key auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'tugas_No',
        'tugas_nama',
        'jenis_id',
        'tugas_tipe',
        'tugas_deskripsi',
        'tugas_kuota',
        'tugas_jam_kompen',
        'tugas_tenggat',
        'kompetensi_id'
    ];

    /**
     * Boot function to automatically generate a UUID for 'tugas_No' when creating a new record.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Automatically generate UUID for tugas_No
        static::creating(function ($model) {
            $model->tugas_No = Str::uuid();
        });
    }

    /**
     * Relationship with the Jenis model.
     * Assuming 'JenisModel' represents the model for 'm_jenis' table.
     */
    public function jenis()
    {
        return $this->belongsTo(JenisModel::class, 'jenis_id', 'jenis_id');
    }

    /**
     * Relationship with the Kompetensi model.
     * Assuming 'KompetensiModel' represents the model for 't_kompetensi' table.
     */
    public function kompetensi()
    {
        return $this->belongsTo(KompetensiModel::class, 'kompetensi_id', 'kompetensi_id');
    }
}
