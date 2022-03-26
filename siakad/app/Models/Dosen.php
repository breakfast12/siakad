<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Awobaz\Compoships\Compoships;


class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'nama_dosen',
        'matkul_id',
        'nip',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'images'
    ];

    // protected $casts = [
    //     "jurusan_id" => "array",
    //     // 'jurusan2_id' => 'array',
    //     // 'jurusan3_id' => 'array',
    //     // 'jurusan4_id' => 'array'
    // ];

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }
}
