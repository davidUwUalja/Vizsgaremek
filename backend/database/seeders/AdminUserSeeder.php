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
        $adminExists = DB::table('users')->where('email', 'admin@admin.com')->exists();

        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('adminpwd'),
                'role' => 'admin', 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
