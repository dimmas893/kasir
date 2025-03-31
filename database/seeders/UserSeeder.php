<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'kode' => 'ADM001',
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'level' => 'admin',
                'remember_token' => Str::random(60),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'KSR001',
                'nama' => 'Kasir Satu',
                'email' => 'kasir@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'level' => 'kasir',
                'remember_token' => Str::random(60),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
