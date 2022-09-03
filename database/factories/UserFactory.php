<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->city(),
            'postalcode' => $this->faker->postcode(),
            'address_line_1' => $this->faker->address(),
            'address_line_2' => $this->faker->word(),
            'country_id' => $country ? $country->id : Country::factory(),
            'position' => $this->faker->word(),
            'salary' => $this->faker->numberBetween(400, 10000),
            'role_id' => $role ? $role->id : Role::factory()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
