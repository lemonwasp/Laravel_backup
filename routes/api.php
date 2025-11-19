<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/profile', function (Request $request) {
    return response()->json([
        'message' => 'Welcome to your profile',
        'app_version' => $request->header('X-App-Version'),
    ]);
})->middleware('ensure.version:1.2.0'); // 별칭을 사용하여 미들웨어 적용

// 임시로 다른 리소스를 위한 더미 라우트 추가 (링 생성을 위해)
Route::get('/users/{user}', function(){})->name('api.users.show');
Route::get('/comments/{comment}', function(){})->name('api.comments.show');

// Article 리소스 컨트롤러 라우트
Route::apiResource('articles', ArticleController::class)->names('api.articles');

Route::post('/publishers', [PublisherController::class, 'store']);

// JWT 인증 라우트
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
});

