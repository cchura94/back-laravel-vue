<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware("auth:sanctum")->group(function(){


    // rutas para CRUD de usuarios
    Route::get("/usuario", [UserController::class, "funListar"]); //->middleware(["auth:sanctum"]);
    Route::post("/usuario", [UserController::class, "funGuardar"]);
    Route::get("/usuario/{id}", [UserController::class, "funMostrar"]);
    Route::put("/usuario/{id}", [UserController::class, "funModificar"]);
    Route::delete("/usuario/{id}", [UserController::class, "funEliminar"]);
    
    Route::apiresource("/persona", PersonaController::class);

    Route::apiResource('/categoria', CategoriaController::class);

});

// Autenticacion Laravel api con LARAVEL SANCTUM
Route::prefix('v1/auth')->group(function(){
    Route::post("login", [AuthController::class, "funLogin"]);
    Route::post("register", [AuthController::class, "funRegistro"]);

    Route::middleware("auth:sanctum")->group(function(){
        Route::get("profile", [AuthController::class, "funPerfil"]);
        Route::post("logout", [AuthController::class, "funSalir"]);
    });
});

// login
Route::get("/no-autorizado", function(){
    return ["message" => "No estás autorizado para ver esta página"];
})->name('login');
