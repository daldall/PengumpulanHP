<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), //ini bisa di ganti password nya sesuai yang kamu mau
            'role' => 'admin',
        ]);
        
        // Create Guru Account
        User::create([
            'name' => 'Guru',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // Create Sample Students
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'nis' => str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'Siswa ' . $i,
                'kelas' => 'XII RPL 2',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);
        }
    }
}
