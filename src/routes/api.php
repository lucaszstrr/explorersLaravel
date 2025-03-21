<?php

use App\Http\Controllers\ExploradorController;
use App\Http\Controllers\InventarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Essa é a rota para criar um novo explorador
Route::post('/exploradores', [ExploradorController::class, 'store']);

//Essa é a rota para atualizar a localização de um explorador específico, passando o id dele na rota
Route::put('/exploradores/{id}', [ExploradorController::class, 'update']);

//Essa é a rota para adicionar um item para um explorador
Route::post('/inventario', [InventarioController::class, 'store']);

//Essa é a rota para fazer a troca de itens entre exploradores
Route::post('/exploradores/trocar', [InventarioController::class, 'trade']);

