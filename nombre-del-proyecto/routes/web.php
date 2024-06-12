<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MenuController,
    TableController,
    AdminController,
    Auth\AuthenticatedSessionController,
    Auth\RegisteredUserController,
    Auth\PasswordResetLinkController,
    Auth\NewPasswordController,
};

// Rutas de autenticación generadas manualmente
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Redirigir a la página de inicio si no está autenticado
Route::get('/', function () {
    return redirect()->route('inicio');
})->middleware('guest');

// Ruta para la página de inicio que carga la vista dashboard.blade.php
Route::get('/inicio', function () {
    return view('dashboard');
})->name('inicio');

// Aplicar middleware de autenticación a todas las demás rutas
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas del menú
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/crear', [MenuController::class, 'crear'])->name('menu.crear');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/gestionar', [MenuController::class, 'gestionar'])->name('menu.gestionar');
    Route::get('/menu/importar', [MenuController::class, 'importar'])->name('menu.importar');
    Route::post('/menu/importar', [MenuController::class, 'importTable'])->name('menu.importTable');
    Route::delete('/tables/custom-delete/{table}', [MenuController::class, 'deleteCustomTable'])->name('table.custom-delete');

    // Rutas relacionadas con TableController
    Route::get('/tables/gestionar', [TableController::class, 'gestionar'])->name('table.gestionar');
    Route::get('/tables/view/{table}', [TableController::class, 'view'])->name('table.view');
    Route::get('/tables/edit/{table}', [TableController::class, 'edit'])->name('table.edit');
    Route::delete('/tables/delete/{table}', [TableController::class, 'deleteTable'])->name('table.delete');
    Route::get('/tables/share/{table}', [TableController::class, 'share'])->name('table.share');
    Route::post('/tables/share/{table}', [TableController::class, 'processShare'])->name('table.processShare');
    Route::delete('/tables/shared-access/{id}', [TableController::class, 'deleteSharedAccess'])->name('table.deleteSharedAccess');
    Route::get('/table/{table}/export/csv', [TableController::class, 'exportCsv'])->name('table.export.csv');
    Route::get('/table/{table}/export/excel', [TableController::class, 'exportExcel'])->name('table.export.excel');
    Route::get('/table/{table}/export/pdf', [TableController::class, 'exportPdf'])->name('table.export.pdf');
    Route::delete('table/{table}/{id}', [TableController::class, 'deleteRecord'])->name('table.deleteRecord');
    Route::put('/table/{table}/{id}', [TableController::class, 'update'])->name('table.update');
    Route::get('/table/{table}/create', [TableController::class, 'create'])->name('table.create');
    Route::post('/table/{table}/store', [TableController::class, 'store'])->name('table.store');
    Route::post('/table/{table}/send-email', [TableController::class, 'sendEmail'])->name('table.sendEmail');
});

// Rutas de administración
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Redirigir a dashboard si intenta acceder a una página no permitida
Route::fallback(function () {
    return redirect()->route('dashboard');
});
