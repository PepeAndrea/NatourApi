<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PathController;
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
    Route::post('/login/{provider}', 'getProviderUser')->name('social_login');
    Route::post('/login','login')->name('login');
    Route::post('/register','register')->name('register'); 
});

//Export routes
Route::controller(ExportController::class)->group(function (){
    Route::get('/export/pdf/{path}','exportPdf')->name('pdf_export');
    Route::get('/export/gpx/{path}','exportGpx')->name('gpx_export');
});


// Endpoint protetti
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/checkUser',[AuthController::class,'checkApiKey'])->name('verify_token');

    Route::post('/sendemail',[EmailController::class,'sendEmail'])->name('send_email');


    //Paths routes
    Route::controller(PathController::class)->group(function (){
        Route::get('/paths/filter','getFilteredPaths')->name('ricerca');
        Route::get('/paths','getAllPaths')->name('percorsi');
        Route::get('/path/{path}','getPath')->name('percorso');
        Route::post('/path','addPath')->name('aggiungi_percorso');
        Route::post('/report/{path}','reportPath')->name('segnala_percorso');

    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $user = $user->with('paths','paths.interestPoints')->get();
    return $user;
});
