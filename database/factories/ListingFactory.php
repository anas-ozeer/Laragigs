<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fake_tags = fake()->word() .','. fake()->word() .','. fake()->word();
        return [
                'title' => fake()->jobTitle(),
                'tags' => $fake_tags,
                'company' => fake()->company(),
                'location' => fake()->address(),
                'email' => fake()->unique()->companyEmail(),
                'website' => fake()->url(),
                'description' => fake()->text()
        ];
    }
}
