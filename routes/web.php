<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ModeleController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SousOptionController;

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

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('categories', CategorieController::class);
        Route::resource('marques', MarqueController::class);
        Route::resource('models', ModeleController::class);
        Route::resource('options', OptionController::class);
        Route::resource('sous-options', SousOptionController::class);
        Route::resource('users', UserController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('feedbacks', FeedbackController::class);
        Route::resource('versions', VersionController::class);
    });
