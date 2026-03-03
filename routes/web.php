<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

use App\Models\Service;

Route::get('/', function () {
    $featuredServices = Service::where('status', 'published')
        ->where('featured', true)
        ->latest()
        ->take(3)
        ->get();
        
    return view('welcome', compact('featuredServices'));
});

// Service Pages
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
