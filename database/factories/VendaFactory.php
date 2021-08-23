<?php

namespace Database\Factories;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venda::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente' => $this->faker->name(),
            'produto_id' => $this->faker->numberBetween(1, 10),
            'quantidade' => $this->faker->numberBetween(1, 10),
            'valor_total' => $this->faker->numberBetween(100, 5000),
            'forma_pagamento' => $this->faker->randomElement(['Dinheiro', 'Cartão de débito', 'Cartão de crédito']),
            'observacoes' => 'Não',
            'status' => true,
            'created_at' => $this->faker->dateTimeBetween(
                $startDate = '-10 days',
                $endDate = 'now',
                $timezone = null
            )
        ];
    }
}
