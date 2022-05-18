<?php

use App\Http\Controllers\API\V1\ArticleController;
use App\Http\Controllers\API\V1\AuthorController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
        'prefix'=>'v1',
        'middleware'=>'auth:sanctum'
    ], function(){

    //Articles
    Route::apiResource('/articles',ArticleController::class);

    //Authors
    Route::get('article/authors/{user}',[AuthorController::class,'show'])->name('authors');
    
    //User
    Route::get('/user',UserController::class);
});