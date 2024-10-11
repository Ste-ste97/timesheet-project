<?php

namespace Database\Seeders;

use App\Models\Navlink;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Navlink::truncate();

        $admin = User::firstOrCreate([
            'name'              => 'Marios',
            'email'             => 'admin@admin.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'is_admin'          => true,
        ]);

        $konstantinos = User::firstOrCreate([
            'name'              => 'Konstantinos',
            'email'             => 'konstantinos@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $stalo = User::firstOrCreate([
            'name'              => 'Stalo',
            'email'             => 'stalo@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $mariaP = User::firstOrCreate([
            'name'              => 'Maria P',
            'email'             => 'mariap@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $maria = User::firstOrCreate([
            'name'              => 'Maria',
            'email'             => 'maria@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);


        $admin->assignRole('admin');
        $konstantinos->assignRole('user');
        $stalo->assignRole('user');
        $mariaP->assignRole('user');
        $maria->assignRole('user');
    }
}
