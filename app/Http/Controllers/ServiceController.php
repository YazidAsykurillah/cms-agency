<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the published services.
     */
    public function index(): View
    {
        $services = Service::where('status', 'published')
            ->orderBy('featured', 'desc')
            ->latest()
            ->get();
            
        return view('services.index', compact('services'));
    }

    /**
     * Display the specified published service by slug.
     */
    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
            
        return view('services.show', compact('service'));
    }
}
