<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'source' => $this->faker->randomElement([]),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Client $client) {
            $n = rand(1, 10);
            for ($i = 0; $i < $n; $i++) {
                Contact::factory()->create(['client_id' => $client->id]);
            }
        });
    }
}