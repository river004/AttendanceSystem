<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Work;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dummyDate = $this->faker->dateTimeThisMonth;

        return [
            'date' => $dummyDate->format('Y-m-d'),
            'start_work' => $dummyDate->format('H:i:s'),
            'end_work' => $dummyDate->modify('+9hour')->format('H:i:s'),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
