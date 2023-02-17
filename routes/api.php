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

Route::controller(CommunityController::class)->group(function () {
    Route::get('/community', 'index')->name('index');
    Route::get('/community/getAll', 'getAll')->name('getAll');
    Route::get('/community/{id}', 'get')->name('get');
    Route::post('/community', 'store')->name('add');
    Route::delete('/community', 'delete')->name('delete');
    Route::patch('/community', 'update')->name('update');
})->name('api.community');


