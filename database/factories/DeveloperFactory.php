<?php

namespace Database\Factories;

use App\Models\Developer;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Developer::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'enabled_at' => null,
        ];
    }

    public function disabled(): self
    {
        return $this->state(function () {
            return [
                'enabled_at' => null,
            ];
        });
    }

    public function enabled(string $date): self
    {
        return $this->state(function () use ($date) {
            return [
                'enabled_at' => $date,
            ];
        });
    }
}
