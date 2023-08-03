<?php

use App\Http\Controllers\API\AI\SentimentAIController;
use App\Http\Controllers\Auth\API\APIAuthController;
use App\Http\Controllers\Auth\API\APISocialAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' =>'ai', 'middleware' => 'auth:api'],function(){
    Route::prefix('love')->group(function(){
        Route::get('/generate',[SentimentAIController::class,'generate']);
    });
});

Route::prefix('auth')->group(function(){
    Route::get('/{provider}',[APISocialAuthController::class,'getProviderRedirect']);
    Route::get('/callback/{provider}',[APISocialAuthController::class,'callback']);
    Route::post('/login', [APIAuthController::class,'login']);
    Route::post('/logout', [APIAuthController::class,'logout']);
});



