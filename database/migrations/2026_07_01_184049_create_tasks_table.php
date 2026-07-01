<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('assignee_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('estado', 30)->default('pendiente');
            $table->string('prioridad', 20)->default('media');
            $table->integer('posicion')->default(0);
            $table->date('due_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'estado']);
            $table->index(['project_id', 'posicion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};