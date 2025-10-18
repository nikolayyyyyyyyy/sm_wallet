<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User seeder
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('12345678'),
            'role_id' => '1'
        ]);
    }
}
