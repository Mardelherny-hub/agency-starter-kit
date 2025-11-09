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

        seo()
            ->title(settings('seo_blog_title', 'Blog'))
            ->description(settings('seo_blog_description', ''))
            ->canonical(route('blog.index'));

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

        // SEO
        $featuredImage = $post->getFirstMediaUrl('featured_image');

        seo()
            ->title($post->meta_title ?: $post->title)
            ->description($post->meta_description ?: $post->excerpt)
            ->image($featuredImage)
            ->canonical(route('blog.show', $post->slug))
            ->openGraph([
                'og:type' => 'article',
                'article:published_time' => $post->published_at->toIso8601String(),
                'article:modified_time' => $post->updated_at->toIso8601String(),
                'article:author' => $post->author->name,
            ])
            ->schema((new \App\Support\SEO\Schema\ArticleSchema($post))->toJson());

        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }
}