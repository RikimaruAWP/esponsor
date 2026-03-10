<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\SupportController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $creator = $request->user()->creator()->with(['links'])->first();

    // Calculamos las métricas usando Eloquent para optimización de BD
    $metrics = [
        'totalGained' => $creator->supports()->sum('amount'), // Suma total en dólares
        'totalSupports' => $creator->supports()->count(), // Cantidad de personas
        'averageSupport' => $creator->supports()->avg('amount') ?? 0, // Promedio
    ];

    // Obtenemos los apoyos paginados en vez de ->get() (Escalabilidad)
    $paginatedSupports = $creator->supports()->latest()->paginate(5);

    return Inertia::render('Dashboard', [
        'creator' => $creator,
        'metrics' => $metrics,
        'supports' => $paginatedSupports
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas Privadas del Creador
    Route::put('/creator/profile', [CreatorController::class, 'update'])->name('creator.update');
    Route::post('/creator/links', [LinkController::class, 'store'])->name('links.store');
    Route::delete('/creator/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
});

// Rutas Públicas (El Perfil eSponsor)
Route::get('/@{slug}', [CreatorController::class, 'show'])->name('creator.show');
Route::post('/@{slug}/support', [SupportController::class, 'store'])->name('support.store');

require __DIR__.'/auth.php';
