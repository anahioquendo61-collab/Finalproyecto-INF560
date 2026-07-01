<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id', 'nombre', 'descripcion', 'estado', 'color',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('project_role')
            ->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('posicion');
    }

    public function pendientes(): HasMany
    {
        return $this->hasMany(Task::class)
            ->where('estado', 'pendiente')
            ->orderBy('posicion');
    }

    public function enProgreso(): HasMany
    {
        return $this->hasMany(Task::class)
            ->where('estado', 'en_progreso')
            ->orderBy('posicion');
    }

    public function completadas(): HasMany
    {
        return $this->hasMany(Task::class)
            ->where('estado', 'completada')
            ->orderBy('posicion');
    }

    public function isMember(User $user): bool
    {
        return $this->members->contains($user->id)
            || $this->owner_id === $user->id;
    }
}