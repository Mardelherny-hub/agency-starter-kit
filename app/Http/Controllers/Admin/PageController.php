<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Pages\Services\PageCrudService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        protected PageCrudService $pageCrudService
    ) {
        $this->middleware('permission:pages.view')->only(['index', 'show']);
        $this->middleware('permission:pages.create')->only(['create', 'store']);
        $this->middleware('permission:pages.edit')->only(['edit', 'update']);
        $this->middleware('permission:pages.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $pages = $this->pageCrudService->paginate();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $this->pageCrudService->create($request->validated());
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function show(int $id)
    {
        $page = $this->pageCrudService->findOrFail($id);
        return view('admin.pages.show', compact('page'));
    }

    public function edit(int $id)
    {
        $page = $this->pageCrudService->findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, int $id)
    {
        $page = $this->pageCrudService->findOrFail($id);
        $this->pageCrudService->update($page, $request->validated());
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(int $id)
    {
        $page = $this->pageCrudService->findOrFail($id);
        $this->pageCrudService->delete($page);
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}