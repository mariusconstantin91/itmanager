<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $document = [
            'name' => $this->faker->unique()->words(3, true),
            'type' => $this->faker->randomElement(['info', 'cv', 'notification', 'application', 'contract']),
            'path' => 'documents/'. $this->fake->asciify('********************') . '.pdf',
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'user_id' => User::inRandomOrder()->first()->id,
        ];

        if ($document['status'] == 'approved') {
            $document['approved_by_id'] = User::whereIn('role_id',[1, 2, 3])->inRandomOrder()->first()->id;
        }

        return $document;
    }
}
