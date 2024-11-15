<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text(),
            'price' => fake()->numberBetween(1000, 100000),
        ];
    }

}
