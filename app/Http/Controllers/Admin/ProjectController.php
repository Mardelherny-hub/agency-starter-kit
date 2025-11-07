<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Portfolio\Services\ProjectCrudService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectCrudService $projectCrudService
    ) {

    }

    public function index(Request $request)
    {
        $projects = $this->projectCrudService->paginate();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = \App\Domain\Portfolio\Models\ProjectCategory::ordered()->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function edit(int $id)
    {
        $project = $this->projectCrudService->findOrFail($id);
        $categories = \App\Domain\Portfolio\Models\ProjectCategory::ordered()->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function store(StoreProjectRequest $request)
    {
        $this->projectCrudService->create($request->validated());
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(int $id)
    {
        $project = $this->projectCrudService->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    public function update(UpdateProjectRequest $request, int $id)
    {
        $project = $this->projectCrudService->findOrFail($id);
        $this->projectCrudService->update($project, $request->validated());
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(int $id)
    {
        $project = $this->projectCrudService->findOrFail($id);
        $this->projectCrudService->delete($project);
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
