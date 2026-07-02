# Trello App — Sistema Web de Gestión de Proyectos Colaborativos

Aplicación web monolítica desarrollada con Laravel 13, Breeze, spatie/laravel-permission
y PostgreSQL, inspirada en Trello. Proyecto Final — INF560 Desarrollo Web Backend — UATF.

## Autor

Carlos Matos Paco — Ingeniería Informática, 5.° semestre — UATF

## Stack tecnológico

| Componente       | Tecnología                        |
|------------------|-----------------------------------|
| Framework        | Laravel 13                        |
| Lenguaje         | PHP 8.3+                          |
| Base de datos    | PostgreSQL                        |
| Autenticación    | Laravel Breeze (sesión nativa)    |
| Roles y permisos | spatie/laravel-permission ^7.0    |
| Vistas           | Blade + Tailwind CSS              |
| Validación       | Form Requests                     |
| Control versión  | Git (entrega por fases con tags)  |

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/matos78630244-max/Proyecto-Final.git
cd trello-app
```

2. Instalar dependencias:
```bash
composer install
npm install
```

3. Copiar el archivo de entorno:
```bash
copy .env.example .env
php artisan key:generate
```

4. Configurar la base de datos en `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=trello_app
DB_USERNAME=trello
DB_PASSWORD=123456
```

5. Ejecutar migraciones y seeders:
```bash
php artisan migrate:fresh --seed
```

6. Compilar assets:
```bash
npm run build
```

7. Levantar el servidor:
```bash
php artisan serve
```

## Usuarios de prueba

| Rol         | Email                    | Contraseña |
|-------------|--------------------------|------------|
| Admin       | admin@trello.com         | password   |
| Líder       | lider@trello.com         | password   |
| Colaborador | colaborador@trello.com   | password   |
| Invitado    | invitado@trello.com      | password   |

## Roles y permisos

| Rol         | Tableros                      | Tareas                          | Usuarios   |
|-------------|-------------------------------|---------------------------------|------------|
| Admin       | CRUD total                    | CRUD total                      | Gestionar  |
| Líder       | Crear y editar los suyos      | Crear, asignar en sus tableros  | —          |
| Colaborador | Ver donde es miembro          | Crear y editar las asignadas    | —          |
| Invitado    | Solo lectura                  | Solo comentar                   | —          |

## Fases de desarrollo

| Tag   | Descripción                                              |
|-------|----------------------------------------------------------|
| v0.1  | Migraciones, modelos, relaciones, factories y seeders    |
| v0.2  | Autenticación con Breeze, layout sidebar estilo Trello   |
| v0.3  | RBAC con spatie, seeder de roles/permisos, Policies      |
| v0.4  | CRUD completo: tableros kanban, tareas, comentarios      |
| v1.0  | Filtros, paginación, dashboard mejorado, README          |