<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;



// Route::get('/test', function () {
//     return response()->json(['message' => 'API working successfully!']);
// });

// Auth
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Protected
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // posts
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);

    // likes
    Route::post('posts/{id}/like', [LikeController::class, 'like']);
    Route::post('posts/{id}/unlike', [LikeController::class, 'unlike']);

    // comments
    Route::post('posts/{id}/comment', [CommentController::class, 'store']);
    Route::get('posts/{id}/comments', [CommentController::class, 'index']);

    // feed
    Route::get('feed', [FeedController::class, 'index']);
});
