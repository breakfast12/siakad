<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama_mahasiswa',
        'nim',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'images'
    ];
}
