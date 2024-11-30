<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryControllerApi;
use App\Http\Controllers\API\ArticleControllerApi;
use App\Http\Controllers\API\SubcategoryControllerApi;
use App\Http\Controllers\API\UserControlerApi;
use App\Http\Controllers\API\OrderApi;


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
Route::get('/articles', [ArticleControllerApi::class, 'index']);
Route::post('/articles', [ArticleControllerApi::class, 'store']);
Route::put('/articles/{id}', [ArticleControllerApi::class, 'update']);
Route::delete('/articles/{id}', [ArticleControllerApi::class, 'destroy']);
Route::get('/articles/{nombre}', [ArticleControllerApi::class, 'searchByNombre']);

Route::get('/categories', [CategoryControllerApi::class, 'index']);
Route::post('/categories', [CategoryControllerApi::class, 'store']);
Route::put('/categories/{id}', [CategoryControllerApi::class, 'update']);
Route::delete('/categories/{id}', [CategoryControllerApi::class, 'destroy']);

Route::get('/subcategories', [SubcategoryControllerApi::class, 'index']);
Route::post('/subcategories', [SubcategoryControllerApi::class, 'store']);
Route::put('/subcategories/{id}', [SubcategoryControllerApi::class, 'update']);
Route::delete('/subcategories/{id}', [SubcategoryControllerApi::class, 'destroy']);

Route::post('/saveOrderDetail', [OrderApi::class, 'saveOrderDetail']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
