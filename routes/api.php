<?php

use App\Http\Controllers\AuthController;
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

// Endpoint pubblici
Route::controller(AuthController::class)->group(function () {
    Route::get('/applogin/{provider}', 'redirectToProvider');
    Route::get('/login/{provider}/callback', 'handleProviderCallback');
    Route::post('/login/{provider}', 'getProviderUser');
    Route::post('/login','login');
    Route::post('/register','register'); 
});


// Endpoint protetti
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
