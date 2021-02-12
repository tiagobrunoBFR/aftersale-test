<?php

namespace Database\Factories;

use App\Models\FavoriteProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FavoriteProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'product_id' => $this->faker->randomNumber(5)
        ];
    }
}
