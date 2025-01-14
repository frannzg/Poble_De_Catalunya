<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PobleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/poble', [PobleController::class, 'index']);  
Route::get('/poble/{id}', [PobleController::class, 'show']);  
Route::get('/obtenirPobles', [PobleController::class, 'obtenirPobles']);
Route::get('/actualizarDatosMunicipios', [PobleController::class, 'actualizarDatosMunicipios']);


