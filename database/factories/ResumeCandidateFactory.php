<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Resume;
use App\Models\ResumeCandidate;

class ResumeCandidateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResumeCandidate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'resume_id' => Resume::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'location' => fake()->word(),
            'linkedin_url' => fake()->word(),
            'github_url' => fake()->word(),
            'portfolio_url' => fake()->word(),
            'updated_at' => fake()->dateTime(),
            'created_at' => fake()->dateTime(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
