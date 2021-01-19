<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', function () {
//     return view('login_page');
// });

// Route::get('login', [LoginController::class,'login']);


Route::middleware('shanzay_middleware_jo_auth_check_kry_ga','shanzay_middleware_jo_custom_logic_check_kry_ga')->group(function () {
    Route::get('test_middleware', [LoginController::class,'logout']);
});
Route::get('project-store','Api\ProjectapiController@projectStore')->name('project.store');
