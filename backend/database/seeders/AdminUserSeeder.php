<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * A felhasználók adatainak betöltése.
     *
     * @return void
     */
    public function run()
    {
        // Ellenőrizzük, hogy már létezik-e admin felhasználó
        $adminExists = DB::table('users')->where('email', 'admin@admin.com')->exists();

        if (!$adminExists) {
            // Ha még nincs, akkor létrehozzuk
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('adminpassword'), // Alap admin jelszó
                'role' => 'admin', // Admin szerepkör
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
