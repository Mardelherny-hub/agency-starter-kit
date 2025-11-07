<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Services\Services\ServiceCrudService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceCrudService $serviceCrudService
    ) {

    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'featured' => $request->input('featured'),
            'status' => $request->input('status'),
        ];

        $services = $this->serviceCrudService->paginate(15, $filters);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $service = $this->serviceCrudService->create($request->validated());

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(int $id)
    {
        $service = $this->serviceCrudService->findOrFail($id);

        return view('admin.services.show', compact('service'));
    }

    public function edit(int $id)
    {
        $service = $this->serviceCrudService->findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, int $id)
    {
        $service = $this->serviceCrudService->findOrFail($id);
        $this->serviceCrudService->update($service, $request->validated());

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(int $id)
    {
        $service = $this->serviceCrudService->findOrFail($id);
        $this->serviceCrudService->delete($service);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}