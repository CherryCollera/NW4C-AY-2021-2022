<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'prod_name' => $this->faker->word(),
            'status' => 'available',
            'est_price' => $this->faker->numerify('###'),
            'prod_qty' => $this->faker->numerify('#'),
            'qty_type' => $this->faker->randomElement(['categ-1','categ-2','categ-3','categ-4','categ-5','categ-6',]),
            'date_produced' => $this->faker->dateTimeBetween('2021-01-01', '2021-07-29')->format('Y-m-d'),
            'date_expiree' =>$this->faker->dateTimeBetween('2021-09-01', '2021-12-30')->format('Y-m-d'),
            'category' => $this->faker->randomElement(['categ-1','categ-2','categ-3','categ-4','categ-5','categ-6',]),
            'views' =>  $this->faker->numerify('##'),
            'preferred_prod' => $this->faker->word(),
        ];
    }
}
