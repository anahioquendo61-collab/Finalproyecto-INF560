<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Label;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Roles y usuarios fijos
        $this->call(RolePermissionSeeder::class);

        // 2) Usuarios extra de prueba
        $extrasUsers = User::factory(6)->create();
        $todosUsers  = User::all();

        // 3) Labels globales
        $labels = Label::factory(6)->create();

        // 4) Proyectos con miembros, tareas y comentarios
        Project::factory(5)
            ->recycle($todosUsers)
            ->create()
            ->each(function (Project $project) use ($todosUsers, $labels) {

                // Agregar miembros al pivote con roles
                $miembros = $todosUsers->random(4);
                foreach ($miembros as $index => $miembro) {
                    $rol = match ($index) {
                        0       => 'lider',
                        1       => 'colaborador',
                        default => 'invitado',
                    };
                    $project->members()->syncWithoutDetaching([
                        $miembro->id => ['project_role' => $rol],
                    ]);
                }

                // Tareas por columna (estado)
                foreach (['pendiente', 'en_progreso', 'completada'] as $posicion => $estado) {
                    Task::factory(3)
                        ->recycle($todosUsers)
                        ->create([
                            'project_id' => $project->id,
                            'estado'     => $estado,
                            'posicion'   => $posicion,
                        ])
                        ->each(function (Task $task) use ($todosUsers, $labels) {
                            // Comentarios
                            Comment::factory(2)
                                ->recycle($todosUsers)
                                ->create(['task_id' => $task->id]);

                            // Etiquetas
                            $task->labels()->sync(
                                $labels->random(rand(1, 2))->pluck('id')
                            );
                        });
                }
            });
    }
}