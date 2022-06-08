<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/stores', [StoreController::class, 'getStores']);
    Route::post('/stores', [StoreController::class, 'createStore']);
    Route::put('/stores/{store_id}', [StoreController::class, 'editStore']);
    Route::delete('/stores/{store_id}', [StoreController::class, 'deleteStore']);

    Route::get('/categories', [CategoryController::class, 'getCategories']);
    Route::post('/categories', [CategoryController::class, 'createCategory']);
    Route::put('/categories/{category_id}', [CategoryController::class, 'editCategory']);
    Route::delete('/categories/{category_id}', [CategoryController::class, 'deleteCategory']);

    Route::get('/items', [ItemController::class, 'getItems']);
    Route::post('/items', [ItemController::class, 'createItem']);
    Route::put('/items/{item_id}', [ItemController::class, 'editItem']);
    Route::delete('/items/{item_id}', [ItemController::class, 'deleteItem']);

});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
