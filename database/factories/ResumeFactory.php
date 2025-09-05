<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Resume;
use App\Models\User;

class ResumeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resume::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'path' => fake()->text(),
            'is_readable' => fake()->boolean(),
            'updated_at' => fake()->dateTime(),
            'created_at' => fake()->dateTime(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
