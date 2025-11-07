<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Blog\Services\PostCrudService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostCrudService $postCrudService
    ) {

    }

    public function index(Request $request)
    {
        $posts = $this->postCrudService->paginate();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = \App\Domain\Blog\Models\PostCategory::ordered()->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        
        $this->postCrudService->create($data);
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function show(int $id)
    {
        $post = $this->postCrudService->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(int $id)
    {
        $post = $this->postCrudService->findOrFail($id);
        $categories = \App\Domain\Blog\Models\PostCategory::ordered()->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, int $id)
    {
        $post = $this->postCrudService->findOrFail($id);
        $this->postCrudService->update($post, $request->validated());
        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(int $id)
    {
        $post = $this->postCrudService->findOrFail($id);
        $this->postCrudService->delete($post);
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
