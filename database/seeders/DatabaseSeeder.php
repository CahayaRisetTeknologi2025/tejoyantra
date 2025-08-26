<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'CRT',
            'email' => 'superadmin@crt.id',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'is_active' => '1',
            'created_at' => now(),
        ]);

        User::create([
            'name' => 'Leo',
            'email' => 'leo@crt.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => '1',
            'created_at' => now(),
        ]);
    }
}
