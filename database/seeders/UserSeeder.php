<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@admin.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'is_admin'          => true,
        ]);

        $niki = User::create([
            'name'              => 'Niki',
            'email'             => 'niki@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $pantelis = User::create([
            'name'              => 'Pantelis',
            'email'             => 'pantelis@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $athina = User::create([
            'name'              => 'Athina',
            'email'             => 'athina@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $costas = User::create([
            'name'              => 'Costas',
            'email'             => 'Costas@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $rena = User::create([
            'name'              => 'Rena',
            'email'             => 'rena@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $spiros = User::create([
            'name'              => 'Spyros',
            'email'             => 'spiros@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $margarita = User::create([
            'name'              => 'Margarita',
            'email'             => 'margarita@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $nikolas = User::create([
            'name'              => 'Nikolas',
            'email'             => 'nikolas@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $thomas = User::create([
            'name'              => 'Thomas',
            'email'             => 'thomas@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);

        $loucas = User::create([
            'name'              => 'Loucas',
            'email'             => 'loucas@test.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ]);


        $admin->assignRole('admin');
        $niki->assignRole('user');
        $pantelis->assignRole('user');
        $athina->assignRole('user');
        $costas->assignRole('user');
        $rena->assignRole('user');
        $spiros->assignRole('user');
        $margarita->assignRole('user');
        $nikolas->assignRole('user');
        $thomas->assignRole('user');
        $loucas->assignRole('user');

    }
}
