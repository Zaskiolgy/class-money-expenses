<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Kas',
            'email'    => 'admin@kas.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Bendahara',
            'email'    => 'bendahara@kas.com',
            'password' => Hash::make('password'),
            'role'     => 'bendahara',
        ]);

        User::create([
            'name'     => 'Wali Kelas',
            'email'    => 'wali@kas.com',
            'password' => Hash::make('password'),
            'role'     => 'wali_kelas',
        ]);
    }
}
