<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnes>
 */
class PersonnesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'matricule' => $this->faker->number_format,
            'nom' => $this->faker->name(),
            'prenoms' => $this->faker->name(),
            'compte_id' => random_int(2,100),
            'genre' => 'M',
            'tel' => 00000000,
            'email' => '',
            'statut_id' => 2,
            'created_by' => 1,
            'ddn' => '2023-05-25',
            'adresse' => 'Here',
            'nationalite' => 'Benin',
        ];
    }
}
