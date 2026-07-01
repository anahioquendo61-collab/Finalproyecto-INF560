<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id'    => User::factory(),
            'nombre'      => fake()->sentence(3),
            'descripcion' => fake()->paragraph(),
            'estado'      => fake()->randomElement(['activo', 'pausado', 'finalizado']),
            'color'       => fake()->randomElement([
                '#6366F1', '#EC4899', '#10B981',
                '#F59E0B', '#3B82F6', '#8B5CF6',
            ]),
        ];
    }
}