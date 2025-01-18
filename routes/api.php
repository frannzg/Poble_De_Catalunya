<?php

use App\Http\Controllers\PobleAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PobleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/obtenirPobles', [PobleController::class, 'obtenirPobles']);
Route::get('/afegirDadesRestants', [PobleController::class, 'afegirDadesRestants']);

/* Rutes per a la API creada per nosaltres */
Route::resource('poble', PobleAPIController::class)->only([
    'index',
    'store',
    'update',
    'destroy',
    'show'
]);
