<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vacation;

class VacationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'type' => fake()->randomElement(["emergency","maternity","hourly","daily","monthly"]),
            'status' => fake()->randomElement(["pending","approved","rejected"]),
            'reject_reason' => fake()->text(),
            'admin_id' => User::factory(),
            'employee_id' => User::factory(),
            'created_at' => fake()->dateTime(),
            'update_at' => fake()->dateTime(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
