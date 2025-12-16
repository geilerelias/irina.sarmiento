<?php

use App\Http\Controllers\AcademicDocumentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ContactController;


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


Route::post('/contact', [ContactController::class, 'send']);

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


Route::get('/test-mail', function () {
    Mail::raw('Correo de prueba', function ($msg) {
        $msg->to('irina.sarmiento@wirelesslink.com.co')
            ->subject('Test Laravel');
    });

    return 'Correo enviado';
});