<?php

use App\Http\Controllers\AcademicDocumentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Models\User;
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
    ->whereIn('category', ['articles', 'research', 'thesis', 'evaluations', 'workshops'])
    ->group(function () {
        // Ver listado
        Route::get('/', [AcademicDocumentController::class, 'index'])->name('index');
        // Crear
        Route::post('/', [AcademicDocumentController::class, 'store'])->name('store');
        // Actualizar
        Route::put('/{document}', [AcademicDocumentController::class, 'update'])->name('update');
        // Eliminar
        Route::delete('/{document}', [AcademicDocumentController::class, 'destroy'])->name('destroy');
    });

Route::prefix('admin/users')
    ->name('admin.users.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', [UserController::class, 'index'])
            ->name('index')
            ->can('viewAny', App\Models\User::class);

        Route::put('/{user}/role', [UserController::class, 'updateRole'])
            ->name('updateRole')
            ->can('update', 'user');
    });

Route::get('/make-admin/{id}', function ($id) {
    $user = User::findOrFail($id);
    $user->role = 'admin';
    $user->save();

    return 'Usuario actualizado a ADMIN';
});

Route::get('/secure-pdf/{path}', [AcademicDocumentController::class, 'showPdf'])
    ->where('path', '.*');

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

Route::get('/storage-link', function () {
    Artisan::call('storage:link');

    return 'Enlace de storage creado correctamente';
});

Route::get('/crear-enlace-storage', function () {

    $origen = storage_path('app/public');
    $destino = public_path('../../irinasarmiento.wirelesslink.com.co/storage');

    if (file_exists($destino)) {
        return 'El enlace o carpeta ya existe';
    }

    if (symlink($origen, $destino)) {
        return 'Enlace creado correctamente';
    }

    return 'El hosting no permite enlaces simbólicos';
});
