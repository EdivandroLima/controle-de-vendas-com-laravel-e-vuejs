<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VendaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/categorias/search', [CategoriaController::class, 'search']);
Route::middleware('auth:api')->get('/categorias/nomes', [CategoriaController::class, 'categorias']); // somente os nomes das categorias
Route::middleware('auth:api')->resource('/categorias', CategoriaController::class);

Route::middleware('auth:api')->get('/produtos/search', [ProdutoController::class, 'search']);
Route::middleware('auth:api')->resource('/produtos', ProdutoController::class);

Route::middleware('auth:api')->get('/vendas', [VendaController::class, 'index']);
Route::middleware('auth:api')->post('/vendas', [VendaController::class, 'store']);
Route::middleware('auth:api')->get('/vendas/search', [VendaController::class, 'search']);
Route::middleware('auth:api')->get('/vendas/dias', [VendaController::class, 'vendasDiarias']);
Route::middleware('auth:api')->delete('/vendas/{venda}', [VendaController::class, 'destroy']);
