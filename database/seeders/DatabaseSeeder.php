<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Super Admin
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@tigasekawan.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => 'super_admin',
        ]);

        // Admin & Costumer
        \App\Models\User::factory()
            ->count(10)
            ->state(new Sequence(
                ['role' => 'admin'],
                ['role' => 'customer'],
            ))
            ->create();

        $this->call([
            MaterialSeeder::class,
            ColorSeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,
        ]);
    }
}
