<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Postcontroller;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\Api\CrawlShopifyDataController;
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

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});


// Route::post('/users/{user}', [UserController::class, 'show']);
Route::get('/user/{id}', [UserController::class, 'getUser']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/user-profiles', [UserProfileController::class, 'store']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products-store', [ProductController::class, 'showProducts']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/edit-products/{id}', [ProductController::class, 'update']);
Route::post('/products', [ProductController::class, 'create']);
Route::post('/products/delete',[ProductController::class, 'delete']);
Route::post('/analyze', [ProductController::class, 'analyzeProductsByDate']);

Route::get('/user-profile/{id}', [UserProfileController::class, 'getUserProfile']);


Route::apiResource('posts', PostController::class);



Route::get('/crawl-shopify-data', [CrawlShopifyDataController::class, 'crawl']);