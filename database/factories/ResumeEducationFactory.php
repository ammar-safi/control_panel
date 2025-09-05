<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Resume;
use App\Models\ResumeEducation;

class ResumeEducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResumeEducation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'resume_id' => Resume::factory(),
            'institution_name' => fake()->word(),
            'degree' => fake()->randomElement(["Bachelors","Master","phd"]),
            'Specialization' => fake()->word(),
            'start_year' => fake()->date(),
            'end_year' => fake()->date(),
            'gpa' => fake()->word(),
            'location' => fake()->word(),
            'updated_at' => fake()->dateTime(),
            'created_at' => fake()->dateTime(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
