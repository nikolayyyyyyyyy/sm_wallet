<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role seeder
        Role::create([
            'role_name' => 'Админ'
        ]);

        Role::create([
            'role_name' => 'Потребител'
        ]);
    }
}
