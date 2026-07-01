<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement([
                'Bug', 'Mejora', 'Urgente',
                'Documentación', 'Diseño', 'Frontend', 'Backend',
            ]),
            'color' => fake()->randomElement([
                '#EF4444', '#F59E0B', '#10B981',
                '#3B82F6', '#8B5CF6', '#EC4899',
            ]),
        ];
    }
}