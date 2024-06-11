<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\admin>
 */
class adminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'email'=>$this->faker->unique()->safeEmail,
            'username'=>$this->faker->unique()->userName,
            'phone_number'=>$this->faker->phoneNumber,
            "password"=>Hash::make('password'),
            "super_admin"=>$this->faker->boolean,
        ];
    }
}
