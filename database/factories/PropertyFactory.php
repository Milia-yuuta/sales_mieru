<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property_name' => $this->faker->company,
            'office_master_id' => 1,
            'area_master_id' => $this->faker->numberBetween(24, 30),
            'structure_property_master_id' => $this->faker->numberBetween(3, 6),
            'right_property_master_id' => $this->faker->numberBetween(7, 9),
            'earthquake_property_master_id' => $this->faker->numberBetween(1, 2),
            'pet_property_master_id' => $this->faker->numberBetween(10, 12),
            'prefecture_master_id' => $this->faker->numberBetween(1,45),
            'code' => $this->faker->randomNumber(9),
            'address1' => $this->faker->city(),
            'address2' => $this->faker->numberBetween(1, 99),
            'nearest_station'  => '宇部新川駅',
            'date_completion' => $this->faker->date('Y-m-d'),
            'Nearest_station_walk_time' => $this->faker->numberBetween(1, 15),
            'bus_stop' => $this->faker->city.'バス停',
            'bus_stop_walk_time' => $this->faker->numberBetween(1, 15),
            'total_unit' => $this->faker->numberBetween(1, 99)
        ];
    }
}
