<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id'  => Project::factory(),
            'assignee_id' => null,
            'titulo'      => fake()->sentence(4),
            'descripcion' => fake()->paragraph(),
            'estado'      => fake()->randomElement(['pendiente', 'en_progreso', 'completada']),
            'prioridad'   => fake()->randomElement(['baja', 'media', 'alta']),
            'posicion'    => fake()->numberBetween(0, 100),
            'due_date'    => fake()->optional()->dateTimeBetween('now', '+1 month'),
        ];
    }
}