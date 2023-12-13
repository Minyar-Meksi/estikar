<?php

namespace Database\Factories;

use App\Models\SousOption;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SousOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SousOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'name' => $this->faker->name(),
            'option_id' => \App\Models\Option::factory(),
        ];
    }
}
