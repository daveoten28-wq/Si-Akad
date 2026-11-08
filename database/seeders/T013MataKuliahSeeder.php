<?php

namespace Database\Seeders;

use App\Models\T013MataKuliah;
use Illuminate\Database\Seeder;

class T013MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['t013_kode_mk' => 'IF101', 't013_nama_mk' => 'Pemrograman Web', 't013_sks' => 3],
            ['t013_kode_mk' => 'IF102', 't013_nama_mk' => 'Basis Data', 't013_sks' => 3],
            ['t013_kode_mk' => 'IF103', 't013_nama_mk' => 'Algoritma dan Struktur Data', 't013_sks' => 4],
        ];

        foreach ($courses as $course) {
            T013MataKuliah::firstOrCreate(
                ['t013_kode_mk' => $course['t013_kode_mk']],
                ['t013_nama_mk' => $course['t013_nama_mk'], 't013_sks' => $course['t013_sks']]
            );
        }
    }
}