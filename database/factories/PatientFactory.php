<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'nick' => $this->faker->name(),
            'birthdate' => $this->faker->date,
            'admission' => $this->faker->date,
            'gender' => 1,
            'civil' => 1,
            'education' => 1,
            'occupation' => 1,
            'country' => 1,
            'situation' => 1,

        ];
    }
}
