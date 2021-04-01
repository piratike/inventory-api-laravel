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

    Route::get('/get-stores', [StoreController::class, 'getStores']);
    Route::post('/new-store/{store_name}', [StoreController::class, 'createStore']);
    Route::put('/edit-store/{store_name}/{new_store_name}', [StoreController::class, 'editStore']);
    Route::delete('/delete-store/{store_name}', [StoreController::class, 'deleteStore']);

    Route::get('/get-categories', [CategoryController::class, 'getCategories']);
    Route::post('/new-category/{category_name}', [CategoryController::class, 'createCategory']);
    Route::put('/edit-category/{category_name}/{new_category_name}', [CategoryController::class, 'editCategory']);
    Route::delete('/delete-category/{category_name}', [CategoryController::class, 'deleteCategory']);

    Route::get('/get-items', [ItemController::class, 'getItems']);
    Route::post('/new-item', [ItemController::class, 'createItem']);
    Route::put('/edit-item', [ItemController::class, 'editItem']);
    Route::delete('/delete-item', [ItemController::class, 'deleteItem']);

});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
