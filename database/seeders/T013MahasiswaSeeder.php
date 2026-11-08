<?php

namespace Database\Seeders;

use App\Models\T013Mahasiswa;
use App\Models\T013User;
use Illuminate\Database\Seeder;

class T013MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $user = T013User::firstOrCreate(
            ['t013_username' => '25.K1.0013'],
            ['t013_password' => bcrypt('password123'), 't013_role_id' => 3]
        );

        T013Mahasiswa::firstOrCreate(
            ['t013_nim' => '25.K1.0013'],
            [
                't013_nama' => 'Dave Austen Susilo',
                't013_prodi' => 'Teknik Informatika',
                't013_user_id' => $user->t013_user_id,
            ]
        );
    }
}