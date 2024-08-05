<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Work;
use App\Models\Rest;

class RestFactory extends Factory
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
            'start_rest' => $dummyDate->format('H:i:s'),
            'end_rest' => $dummyDate->modify('+1hour')->format('H:i:s'),
            'work_id' => function () {
                return Work::factory()->create()->id;
            },
        ];
    }
}
