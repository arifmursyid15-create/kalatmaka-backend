<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kalatmaka.id'],
            [
                'name' => 'Admin Kalatmaka',
                'email' => 'admin@kalatmaka.id',
                'password' => Hash::make('kalatmaka2024'),
            ]
        );
    }
}
