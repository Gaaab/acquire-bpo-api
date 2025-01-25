<?php

namespace Acquire\Modules\Customer\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $age = fake()->numberBetween(18, 60);

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'dob' => now()->subYears($age)->format('Y-m-d'),
            'age' => $age,
        ];
    }
}
