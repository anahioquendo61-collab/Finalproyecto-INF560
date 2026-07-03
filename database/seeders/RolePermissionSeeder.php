<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1) Permisos atómicos
        $permisos = [
            'ver proyecto', 'crear proyecto', 'editar proyecto',
            'eliminar proyecto', 'gestionar miembros',
            'ver tarea', 'crear tarea', 'editar tarea',
            'eliminar tarea', 'asignar tarea',
            'comentar', 'gestionar usuarios',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2) Roles con sus permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $lider = Role::firstOrCreate(['name' => 'lider']);
        $lider->syncPermissions([
            'ver proyecto', 'crear proyecto', 'editar proyecto',
            'gestionar miembros',
            'ver tarea', 'crear tarea', 'editar tarea',
            'eliminar tarea', 'asignar tarea', 'comentar',
        ]);

        $colaborador = Role::firstOrCreate(['name' => 'colaborador']);
        $colaborador->syncPermissions([
            'ver proyecto',
            'ver tarea', 'crear tarea', 'editar tarea', 'comentar',
        ]);

        $invitado = Role::firstOrCreate(['name' => 'invitado']);
        $invitado->syncPermissions([
            'ver proyecto', 'ver tarea', 'comentar',
        ]);

        // 3) Usuarios fijos de prueba
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gestorjira.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        $adminUser->assignRole('admin');

        $liderUser = User::firstOrCreate(
            ['email' => 'lider@gestorjira.com'],
            ['name' => 'Lider', 'password' => Hash::make('password')]
        );
        $liderUser->assignRole('lider');

        $colaboradorUser = User::firstOrCreate(
            ['email' => 'colaborador@gestorjira.com'],
            ['name' => 'Colaborador', 'password' => Hash::make('password')]
        );
        $colaboradorUser->assignRole('colaborador');

        $invitadoUser = User::firstOrCreate(
            ['email' => 'invitado@gestorjira.com'],
            ['name' => 'Invitado', 'password' => Hash::make('password')]
        );
        $invitadoUser->assignRole('invitado');
    }
}