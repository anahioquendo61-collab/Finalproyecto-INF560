<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $user  = auth()->user();
        $query = $user->hasRole('admin')
            ? Project::with('owner')
            : Project::with('owner')->where(function ($q) use ($user) {
                $q->where('owner_id', $user->id)
                  ->orWhereHas('members', fn($q) => $q->where('users.id', $user->id));
            });

        if ($request->filled('buscar')) {
            $query->where('nombre', 'ilike', '%' . $request->buscar . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $projects = $query->latest()->paginate(12)->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        $project = Project::create([
            ...$request->validated(),
            'owner_id' => auth()->id(),
            'color'    => $request->color ?? '#6366F1',
        ]);

        $project->members()->attach(auth()->id(), ['project_role' => 'lider']);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tablero creado correctamente.');
    }

    public function show(Project $project, Request $request): View
    {
        $this->authorize('view', $project);

        $project->load(['owner', 'members']);

        $pendientes  = $project->pendientes()->with(['assignee', 'labels'])->get();
        $enProgreso  = $project->enProgreso()->with(['assignee', 'labels'])->get();
        $completadas = $project->completadas()->with(['assignee', 'labels'])->get();

        $members = $project->members;
        $labels  = \App\Models\Label::all();

        return view('projects.show', compact(
            'project', 'pendientes', 'enProgreso', 'completadas', 'members', 'labels'
        ));
    }

    public function edit(Project $project): View
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);
        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tablero actualizado correctamente.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Tablero eliminado correctamente.');
    }
}