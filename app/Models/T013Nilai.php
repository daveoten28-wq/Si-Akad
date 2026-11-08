<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T013Nilai extends Model
{
    use HasFactory;

    protected $table = 't013_nilais';
    protected $primaryKey = 't013_nilai_id';
    protected $fillable = ['t013_mahasiswa_id', 't013_mk_id', 't013_nilai_angka', 't013_nilai_huruf'];

    // Tambahkan relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(T013Mahasiswa::class, 't013_mahasiswa_id', 't013_mahasiswa_id');
    }

    // Tambahkan relasi ke Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(T013MataKuliah::class, 't013_mk_id', 't013_mk_id');
    }
}