<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->sentence(2),
            'quantidade' => $this->faker->numberBetween(5, 30),
            'codigo' => $this->faker->numberBetween(10000, 10000000),
            'valor' => $this->faker->numberBetween(30, 3000),
            'categoria_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
