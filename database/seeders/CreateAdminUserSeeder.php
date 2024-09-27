<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Md. Reyajul Islam',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $user->assignRole([1]);
    }
}
