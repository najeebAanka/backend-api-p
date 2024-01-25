<?php

use App\Http\Controllers\Api\v1\ArticleController;
use App\Http\Controllers\Api\v1\CompetitionController;
use App\Http\Controllers\Api\v1\ConfigController;
use App\Http\Controllers\Api\v1\NotificaionsController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {

    Route::get('/start', [ConfigController::class, 'start']);
    Route::get('/home', [ConfigController::class, 'home']);
    Route::get('/filters', [ConfigController::class, 'filters']);
    Route::get('/brands', [ConfigController::class, 'brands']);
    Route::get('/cars', [ConfigController::class, 'cars']);
    Route::get('/news', [ConfigController::class, 'news']);
    Route::get('/cars/details/{slug?}', [ConfigController::class, 'car']);
    Route::post('/contact-us', [ConfigController::class, 'contactUs']);
    Route::post('/job-request', [ConfigController::class, 'jobRequest']);
    Route::get('/reviews', [ConfigController::class, 'reviews']);
    Route::get('/partners', [ConfigController::class, 'partners']);
    Route::get('/quote', [ConfigController::class, 'quote']);
    Route::post('/quote', [ConfigController::class, 'quoteSave']);

//    Route::group(['prefix' => 'users'], function () {
//        Route::post('/login', [UserController::class, 'login']);
//        Route::post('/register', [UserController::class, 'register']);
//        Route::post('/register/send-code', [UserController::class, 'sendCode']);
//        Route::post('/register/verify-code', [UserController::class, 'verifyCode']);
//        Route::post('/forget-password', [UserController::class, 'forgetPassword']);
//        Route::post('/reset-password', [UserController::class, 'resetPassword']);
//    });


    Route::group(['middleware' => 'auth:sanctum'], function () {

//        Route::group(['prefix' => 'users'], function () {
//            Route::get('/info', [UserController::class, 'info']);
//            Route::post('/update', [UserController::class, 'update']);
//            Route::post('/update-platform-fields', [UserController::class, 'updatePlatformFields']);
//            Route::post('/logout', [UserController::class, 'logout']);
//            Route::post('/delete', [UserController::class, 'delete']);
//        });

    });
});
