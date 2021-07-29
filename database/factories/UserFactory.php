<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'sei' => $this->faker->name,
                'mei' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => Hash::make('1234567890'),
                'office_master_id' => 1,
                'status_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
