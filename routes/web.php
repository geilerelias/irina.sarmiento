<?php

use App\Http\Controllers\AcademicDocumentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('welcome');

Route::get('/', function () {
    return Inertia::render('Home', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/about', function () {
    return Inertia::render('About', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('about');

/* Route::prefix('academic-production')
    ->name('academic-production.')
    ->group(function () {

        $sharedProps = [
            'canRegister' => Features::enabled(Features::registration()),
        ];

        Route::get('/', fn () => Inertia::render('AcademicProduction/Index', $sharedProps)
        )->name('index');

        Route::get('/articles', fn () => Inertia::render('AcademicProduction/ScientificArticles', $sharedProps)
        )->name('articles');

        Route::get('/research', fn () => Inertia::render('AcademicProduction/IndependentResearch', $sharedProps)
        )->name('research');

        Route::get('/thesis', fn () => Inertia::render('AcademicProduction/DoctoralThesis', $sharedProps)
        )->name('thesis');

        Route::get('/evaluations', fn () => Inertia::render('AcademicProduction/AcademicEvaluations', $sharedProps)
        )->name('evaluations');

        Route::get('/workshops', fn () => Inertia::render('AcademicProduction/AcademicWorkshops', $sharedProps)
        )->name('workshops');

    }); */

// Ruta general de academia (sin categoría)
Route::get('/academic-production', function () {
    // Aquí podemos devolver una vista "general" o un redirect
    return Inertia::render('AcademicProduction/Index');
})->name('academic-production.index');

// Ruta dinámica de categorías
Route::get('/academic-production/{category}', [AcademicDocumentController::class, 'showCategory'])
    ->whereIn('category', ['articles', 'research', 'thesis', 'evaluations', 'workshops'])
    ->name('academic-production.category');

Route::prefix('admin/academic-production/{category}')
    ->name('admin.academic-production.')
    ->middleware(['auth'])
    ->whereIn('category', [
        'articles',
        'research',
        'thesis',
        'evaluations',
        'workshops',
    ])
    ->group(function () {
        Route::get('/', [AcademicDocumentController::class, 'index'])->name('index');
        Route::post('/', [AcademicDocumentController::class, 'store'])->name('store');
        Route::put('/{document}', [AcademicDocumentController::class, 'update'])->name('update');
        Route::delete('/{document}', [AcademicDocumentController::class, 'destroy'])->name('destroy');
    });

Route::get('/secure-pdf/{path}', [AcademicDocumentController::class, 'showPdf'])
    ->where('path', '.*')
    ->middleware('auth');

Route::get('/contact', function () {
    return Inertia::render('Contact', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AcademicDocumentController::class, 'dashboard'])
        ->name('dashboard');
});

Route::get('example', function () {
    return Inertia::render('Example');
})->name('example');

require __DIR__.'/settings.php';
