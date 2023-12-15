<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware("auth:sanctum")->group(function(){

    // buscar Cliente
    Route::get("/cliente/buscar-cliente", [ClienteController::class, "buscarCliente"]); 

    // actualizar imagen de producto
    Route::post("producto/{id}/actualizar-imagen", [ProductoController::class, "actualizarImagen"]);

    // rutas para CRUD de usuarios
    Route::get("/usuario", [UserController::class, "funListar"]); //->middleware(["auth:sanctum"]);
    Route::post("/usuario", [UserController::class, "funGuardar"]);
    Route::get("/usuario/{id}", [UserController::class, "funMostrar"]);
    Route::put("/usuario/{id}", [UserController::class, "funModificar"]);
    Route::delete("/usuario/{id}", [UserController::class, "funEliminar"]);
    
    Route::apiresource("/persona", PersonaController::class);

    Route::apiResource('/categoria', CategoriaController::class);

    Route::apiResource("/producto", ProductoController::class);

    Route::apiresource("/pedido", PedidoController::class);
    Route::apiresource("/cliente", ClienteController::class);

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
