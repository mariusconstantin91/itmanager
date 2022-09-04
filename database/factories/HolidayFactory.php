<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->faker->dateTimeBetween('-1 years')->format('Y-m-d H:i:s'));
        $endDate = clone $startDate->addDays(rand(0, 10));

        $holiday = [
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'user_id' => User::inRandomOrder()->first()->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'note' => $this->faker->realText(),
        ];

        if ($holiday['status'] == 'approved') {
            $holiday['approved_by_id'] = User::whereIn('role_id',[1, 2, 3])->inRandomOrder()->first()->id;
        }

        return $holiday;
    }
}
