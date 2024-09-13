<?php

use App\Http\Controllers\API\v1\Authentication\LoginController;
use App\Http\Controllers\API\v1\Authentication\LogoutController;
use App\Http\Controllers\API\v1\FileUploader\FileUploaderController;
use App\Http\Controllers\API\v1\Product\ProductController;
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

Route::prefix('/v1')->name('api.v1.')->group(function() {

    //AUTHENTICATION
    Route::prefix('authentication/')->name('authentication.')->group(function() {
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
    });
    
    //AUTHENTICATED USER
    Route::middleware('auth:sanctum')->group(function() {

        //PRODUCT
        Route::prefix('products')->controller(ProductController::class)->name('product.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{product}', 'update')->name('update');
        });

        //FILE UPLOADER
        Route::prefix('uploader')->controller(FileUploaderController::class)->name('uploader.')->group(function() {
            Route::post('/upload', 'upload')->name('upload');
            Route::post('/revert', 'revert')->name('revert');
        });

        //USER
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        
    });


});


