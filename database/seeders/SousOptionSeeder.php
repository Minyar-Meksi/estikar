<?php

namespace Database\Seeders;

use App\Models\SousOption;
use Illuminate\Database\Seeder;

class SousOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SousOption::factory()
            ->count(5)
            ->create();
    }
}
