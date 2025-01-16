<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::post('/', [MainController::class, 'obtenirById'])->name('ajax.main.obtenirById');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [AdminController::class,'index'])->name('dashboard');
    Route::post('/dashboard/crear', [AdminController::class, 'crear'])->name('ajax.welcome.crear');
    Route::post('/dashboard', [AdminController::class, 'obtenirById'])->name('ajax.welcome.obtenirById');
    Route::post('/dashboard/editar', [AdminController::class, 'editar'])->name('ajax.welcome.editar');
    Route::post('/dashboard/eliminar', [AdminController::class, 'eliminar'])->name('ajax.welcome.eliminar');
});
