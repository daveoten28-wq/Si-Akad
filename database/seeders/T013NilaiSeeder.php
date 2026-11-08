<?php

namespace Database\Seeders;

use App\Models\T013Mahasiswa;
use App\Models\T013MataKuliah;
use App\Models\T013Nilai;
use Illuminate\Database\Seeder;

class T013NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = T013Mahasiswa::where('t013_nim', '25.K1.0013')->first();
        if (! $mahasiswa) {
            return;
        }

        foreach (T013MataKuliah::all() as $matakuliah) {
            T013Nilai::firstOrCreate(
                [
                    't013_mahasiswa_id' => $mahasiswa->t013_mahasiswa_id,
                    't013_mk_id' => $matakuliah->t013_mk_id,
                ],
                [
                    't013_nilai_angka' => 85.5,
                    't013_nilai_huruf' => 'A',
                ]
            );
        }
    }
}