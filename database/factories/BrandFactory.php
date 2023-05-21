<?php

namespace Database\Factories;

use App\Models\Brand;


use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Brand::class;
    public function definition()
    {
        return [
            'name'=>$this->faker->word()
        ];
    }
}
