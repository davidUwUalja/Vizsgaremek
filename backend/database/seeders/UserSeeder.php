<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Jelszó hash-eléséhez

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Teszt Felhasználó',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // Hash-elt jelszó
        ]);
        User::factory()->count(10)->create(); // További 10 felhasználó létrehozása
    }
}