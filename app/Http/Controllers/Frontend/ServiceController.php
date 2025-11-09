<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Domain\Services\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display services listing.
     */
    public function index()
    {
        $services = Service::published()
            ->ordered()
            ->get();

        return view('frontend.services.index', compact('services'));
    }

    /**
     * Display single service.
     */
    public function show(Service $service)
    {
        // Verificar que esté publicado
        if (!$service->published_at || $service->published_at->isFuture()) {
            abort(404);
        }

        // Otros servicios
        $otherServices = Service::published()
            ->where('id', '!=', $service->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('frontend.services.show', compact('service', 'otherServices'));
    }
}