<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', [LoginController::class,'test']);


Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('login', [LoginController::class,'login']);
});

Route::middleware('auth:api','cors')->group(function () {
    Route::post('logout', [LoginController::class,'logout']);
    Route::get('test', [LoginController::class,'test']);

});
