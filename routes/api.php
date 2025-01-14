<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PobleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/poble', [PobleController::class, 'index']);  // Obtener todos los pueblos
Route::get('/poble/{id}', [PobleController::class, 'show']);  // Obtener un pueblo específico por ID
Route::get('/obtenir_municipis', [PobleController::class, 'obtenirMunicipis']);

