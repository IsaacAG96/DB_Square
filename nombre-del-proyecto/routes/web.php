<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

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
Route::middleware(['auth.custom', 'auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/crear', [MenuController::class, 'crear'])->name('menu.crear');
    Route::get('/menu/gestionar', [MenuController::class, 'gestionar'])->name('menu.gestionar');
    Route::get('/menu/importar', [MenuController::class, 'importar'])->name('menu.importar');
    Route::post('/menu/importar', [MenuController::class, 'importTable'])->name('menu.importTable');

   // Añadir rutas para ver, editar y eliminar tablas
   Route::get('/table/view/{table}', [MenuController::class, 'viewTable'])->name('table.view');
   Route::get('/table/edit/{table}', [MenuController::class, 'editTable'])->name('table.edit');
   Route::get('/menu/gestionar', [MenuController::class, 'gestionarTablas'])->name('menu.gestionar');
   Route::delete('/table/delete/{table}', [MenuController::class, 'deleteTable'])->name('table.delete');
});

// Redirigir a /inicio si intenta acceder a una página no permitida
Route::fallback(function () {
    return redirect()->route('inicio');
});
