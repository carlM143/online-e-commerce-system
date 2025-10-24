<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['name']);
            },
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'image_url' => 'https://placehold.co/300x300?text=' . urlencode($this->faker->word),
        ];
    }
}
