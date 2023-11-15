<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// rutas para CRUD de usuarios
Route::get("/usuario", [UserController::class, "funListar"]);
Route::post("/usuario", [UserController::class, "funGuardar"]);
Route::get("/usuario/{id}", [UserController::class, "funMostrar"]);
Route::put("/usuario/{id}", [UserController::class, "funModificar"]);
Route::delete("/usuario/{id}", [UserController::class, "funEliminar"]);

Route::apiresource("/persona", PersonaController::class);