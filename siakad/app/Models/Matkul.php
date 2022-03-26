<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Awobaz\Compoships\Compoships;


class Matkul extends Model
{
    use HasFactory;

    protected $table = 'matkul';
    protected $primaryKey = 'id_matkul';

    protected $fillable = [
        'nama_mata_kuliah',
        'jurusan_id'
    ];

    // protected $casts = [
    //     "jurusan_id" => "array",
    //     // 'jurusan2_id' => 'array',
    //     // 'jurusan3_id' => 'array',
    //     // 'jurusan4_id' => 'array'
    // ];

    public function jurusan()
    {
        // return $this->hasOne(Jurusan::class);
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }
}
