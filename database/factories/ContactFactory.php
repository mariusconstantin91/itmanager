<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->city(),
            'postalcode' => $this->faker->postcode(),
            'address_line_1' => $this->faker->address(),
            'address_line_2' => $this->faker->address(),
            'main_contact' => $this->faker->boolean(),
            'position' => $this->faker->word(),
            'country_id' => Country::factory(),
        ];
    }
}