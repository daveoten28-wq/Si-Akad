<?php

namespace Database\Seeders;

use App\Models\T013Mahasiswa;
use App\Models\T013MataKuliah;
use App\Models\T013Nilai;
use App\Models\T013Role;
use App\Models\T013User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect(['Admin', 'Dosen', 'Mahasiswa'])
            ->mapWithKeys(function ($name) {
                $role = T013Role::firstOrCreate(['t013_role_name' => $name]);

                return [$name => $role];
            });

        $adminUser = T013User::firstOrCreate(
            ['t013_username' => 'admin013'],
            ['t013_password' => Hash::make('password123'), 't013_role_id' => $roles['Admin']->t013_role_id]
        );

        $dosenUser = T013User::firstOrCreate(
            ['t013_username' => 'dosen013'],
            ['t013_password' => Hash::make('password123'), 't013_role_id' => $roles['Dosen']->t013_role_id]
        );

        $mahasiswaUser = T013User::firstOrCreate(
            ['t013_username' => '25.K1.0013'],
            ['t013_password' => Hash::make('password123'), 't013_role_id' => $roles['Mahasiswa']->t013_role_id]
        );

        $mahasiswa = T013Mahasiswa::firstOrCreate(
            ['t013_nim' => '25.K1.0013'],
            [
                't013_nama' => 'Dave Austen Susilo',
                't013_prodi' => 'Teknik Informatika',
                't013_user_id' => $mahasiswaUser->t013_user_id,
            ]
        );

        if (! $mahasiswa->t013_user_id) {
            $mahasiswa->update(['t013_user_id' => $mahasiswaUser->t013_user_id]);
        }

        $matakuliahList = [
            ['t013_kode_mk' => 'IF101', 't013_nama_mk' => 'Pemrograman Web', 't013_sks' => 3],
            ['t013_kode_mk' => 'IF102', 't013_nama_mk' => 'Basis Data', 't013_sks' => 3],
            ['t013_kode_mk' => 'IF103', 't013_nama_mk' => 'Algoritma dan Struktur Data', 't013_sks' => 4],
        ];

        $matakuliahRecords = [];
        foreach ($matakuliahList as $mk) {
            $matakuliahRecords[] = T013MataKuliah::firstOrCreate(
                ['t013_kode_mk' => $mk['t013_kode_mk']],
                ['t013_nama_mk' => $mk['t013_nama_mk'], 't013_sks' => $mk['t013_sks']]
            );
        }

        foreach ($matakuliahRecords as $matakuliah) {
            T013Nilai::firstOrCreate(
                [
                    't013_mahasiswa_id' => $mahasiswa->t013_mahasiswa_id,
                    't013_mk_id' => $matakuliah->t013_mk_id,
                ],
                [
                    't013_nilai_angka' => 85.50,
                    't013_nilai_huruf' => 'A',
                ]
            );
        }

        $this->call([
            T013MahasiswaSeeder::class,
            T013MataKuliahSeeder::class,
            T013NilaiSeeder::class,
        ]);
    }
}
