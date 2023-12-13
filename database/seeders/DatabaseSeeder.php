<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(CategorieSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(MarqueSeeder::class);
        $this->call(ModeleSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(SousOptionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VersionSeeder::class);
    }
}
