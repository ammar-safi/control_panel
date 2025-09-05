<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Resume;
use App\Models\ResumeInterest;

class ResumeInterestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResumeInterest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'resume_id' => Resume::factory(),
            'interested_in' => fake()->numberBetween(-100000, 100000),
            'updated_at' => fake()->dateTime(),
            'created_at' => fake()->dateTime(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
