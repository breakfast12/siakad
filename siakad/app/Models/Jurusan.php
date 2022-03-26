<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use \Awobaz\Compoships\Compoships;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'nama_jurusan'
    ];

    // protected $with = [matkul];

    public function matkul() {
        return $this->hasMany(Matkul::class);
        // return $this->belongsTo(Matkul::class);
    }
}
