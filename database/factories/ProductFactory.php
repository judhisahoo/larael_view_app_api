<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
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
            'price' => mt_rand(100,1000),
            'status' => mt_rand(0,1),
            'upc' => Str::random(10),
            'image' => Str::random(10).'.jpg'
        ];
    }
}
