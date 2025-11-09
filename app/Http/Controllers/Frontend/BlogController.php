<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Blog\Models\Post;
use App\Domain\Blog\Models\PostCategory;

class BlogController extends Controller
{
    /**
     * Display blog listing.
     */
    public function index()
    {
        $posts = Post::published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        $categories = PostCategory::has('publishedPosts')
            ->withCount('publishedPosts')
            ->ordered()
            ->get();

        return view('frontend.blog.index', compact('posts', 'categories'));
    }

    /**
     * Display posts by category.
     */
    public function category(PostCategory $category)
    {
        $posts = $category->publishedPosts()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        $categories = PostCategory::has('publishedPosts')
            ->withCount('publishedPosts')
            ->ordered()
            ->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'category'));
    }

    /**
     * Display single post.
     */
    public function show(Post $post)
    {
        // Verificar que esté publicado
        if (!$post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        // Incrementar vistas
        $post->incrementViews();

        // Posts relacionados (misma categoría)
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }
}