<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Resume;
use App\Models\ResumeExperience;

class ResumeExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResumeExperience::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'resume_id' => Resume::factory(),
            'company_name' => fake()->word(),
            'location' => fake()->word(),
            'description' => fake()->text(),
            'job_title' => fake()->word(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'updated_at' => fake()->dateTime(),
            'created_at' => fake()->dateTime(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
