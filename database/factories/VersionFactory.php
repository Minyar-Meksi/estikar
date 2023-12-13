<?php

namespace Database\Factories;

use App\Models\Version;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Version::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'picture' => $this->faker->text(255),
            'year' => $this->faker->year(),
            'modele_id' => \App\Models\Modele::factory(),
        ];
    }
}
