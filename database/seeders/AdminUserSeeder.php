<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'florentinakemevor@gmail.com'],
            [
                'name'     => 'Florentina Kemevor',
                'password' => 'P@$$Word2025',
            ]
        );
    }
}
