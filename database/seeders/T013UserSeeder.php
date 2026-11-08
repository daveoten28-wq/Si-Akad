<?php

namespace Database\Seeders;

use App\Models\T013Role;
use App\Models\T013User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class T013UserSeeder extends Seeder
{
    public function run(): void
    {
        $role = T013Role::firstOrCreate(['t013_role_name' => 'Mahasiswa']);

        T013User::firstOrCreate(
            ['t013_username' => '25.K1.0013'],
            [
                't013_password' => Hash::make('password123'),
                't013_role_id' => $role->t013_role_id,
            ]
        );
    }
}
