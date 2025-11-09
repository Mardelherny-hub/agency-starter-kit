<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Blog\Models\Post;
use App\Domain\Portfolio\Models\Project;
use App\Domain\Services\Models\Service;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Featured services
        $services = Service::published()
            ->featured()
            ->ordered()
            ->take(6)
            ->get();

        // Recent projects
        $projects = Project::published()
            ->with('category')
            ->latest('published_at')
            ->take(6)
            ->get();

        // Recent blog posts
        $posts = Post::published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.home', compact('services', 'projects', 'posts'));
    }
}