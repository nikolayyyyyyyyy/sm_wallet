<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'role_name' => 'Админ'
        ]);

        Role::create([
            'role_name' => 'Потребител'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('12345678'),
            'role_id' => '1'
        ]);
    }
}
