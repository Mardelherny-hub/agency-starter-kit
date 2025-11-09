<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Portfolio\Models\Project;
use App\Domain\Portfolio\Models\ProjectCategory;

class PortfolioController extends Controller
{
    /**
     * Display portfolio listing.
     */
    public function index()
    {
        $projects = Project::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        $categories = ProjectCategory::has('publishedProjects')
            ->withCount('publishedProjects')
            ->ordered()
            ->get();

        return view('frontend.portfolio.index', compact('projects', 'categories'));
    }

    /**
     * Display projects by category.
     */
    public function category(ProjectCategory $category)
    {
        $projects = $category->publishedProjects()
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        $categories = ProjectCategory::has('publishedProjects')
            ->withCount('publishedProjects')
            ->ordered()
            ->get();

        return view('frontend.portfolio.index', compact('projects', 'categories', 'category'));
    }

    /**
     * Display single project.
     */
    public function show(Project $project)
    {
        // Verificar que esté publicado
        if (!$project->published_at || $project->published_at->isFuture()) {
            abort(404);
        }

        // Incrementar vistas
        $project->incrementViews();

        // Proyectos relacionados (misma categoría)
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->where('category_id', $project->category_id)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.portfolio.show', compact('project', 'relatedProjects'));
    }
}