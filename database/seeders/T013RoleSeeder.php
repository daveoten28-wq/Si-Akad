<?php

namespace Database\Seeders;

use App\Models\T013Role;
use Illuminate\Database\Seeder;

class T013RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Admin', 'Dosen', 'Mahasiswa'] as $roleName) {
            T013Role::firstOrCreate(['t013_role_name' => $roleName]);
        }
    }
}
