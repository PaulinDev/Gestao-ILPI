<?php

namespace Database\Factories;

use App\Models\EventActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'activity' => mt_rand(1, 4),
            'patient' => mt_rand(1, 200),
            'title' => $this->faker->name,
            'repeatDays' => json_encode([
                $this->faker->randomElement(
                    [
                        0,
                        1,
                        2,
                        3,
                        4,
                        5,
                        6
                    ]
                )
            ]),
            'allDay' => 0,
            'timeEnd' => 0,
            'timeStart' => $this->faker->time(),
            'date' => $this->faker->dateTimeBetween('-30 weeks', 'now'),
            'end' => $this->faker->dateTimeBetween('-30 weeks', 'now'),
        ];
    }
}
