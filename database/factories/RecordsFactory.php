<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecordsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->domainWord(),
            'photo'=>$this->faker->imageUrl($width = 640, $height = 480),
            'location'=>$this->faker->address(),
            'latitude'=>$this->faker->latitude($min = -90, $max = 90) ,
            'longitude'=>$this->faker->longitude($min = -180, $max = 180),
            'pincode'=>$this->faker->postcode(),
            'topic'=>$this->faker->word()
        ];
    }
}
