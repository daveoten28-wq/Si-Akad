<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T013Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 't013_mahasiswas';
    protected $primaryKey = 't013_mahasiswa_id';
    protected $fillable = ['t013_nim', 't013_nama', 't013_prodi', 't013_user_id'];
}