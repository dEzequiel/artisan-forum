<?php

use App\Http\Controllers\CommunityController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/community', [CommunityController::class, 'index']);
Route::get('/community/getAll', [CommunityController::class, 'getAll']);
Route::get('/community/{id}', [CommunityController::class, 'get']);
Route::post('/community', [CommunityController::class, 'store']);
Route::delete('/community', [CommunityController::class, 'delete']);
Route::patch('/community', [CommunityController::class, 'update']);
