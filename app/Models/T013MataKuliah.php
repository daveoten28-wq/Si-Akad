<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T013MataKuliah extends Model
{
    use HasFactory;

    protected $table = 't013_matakuliah';
    protected $primaryKey = 't013_mk_id';
    protected $fillable = ['t013_kode_mk', 't013_nama_mk', 't013_sks'];
}