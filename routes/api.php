<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MarqueController;
use App\Http\Controllers\Api\ModeleController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\SousOptionController;
use App\Http\Controllers\Api\MarqueModelesController;
use App\Http\Controllers\Api\ModeleVersionsController;
use App\Http\Controllers\Api\VersionOptionsController;
use App\Http\Controllers\Api\OptionVersionsController;
use App\Http\Controllers\Api\CategorieMarquesController;
use App\Http\Controllers\Api\OptionSousOptionsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('categories', CategorieController::class);

        // Categorie Marques
        Route::get('/categories/{categorie}/marques', [
            CategorieMarquesController::class,
            'index',
        ])->name('categories.marques.index');
        Route::post('/categories/{categorie}/marques', [
            CategorieMarquesController::class,
            'store',
        ])->name('categories.marques.store');

        Route::apiResource('marques', MarqueController::class);

        // Marque Modeles
        Route::get('/marques/{marque}/modeles', [
            MarqueModelesController::class,
            'index',
        ])->name('marques.modeles.index');
        Route::post('/marques/{marque}/modeles', [
            MarqueModelesController::class,
            'store',
        ])->name('marques.modeles.store');

        Route::apiResource('models', ModeleController::class);

        // Modele Versions
        Route::get('/modeles/{modele}/versions', [
            ModeleVersionsController::class,
            'index',
        ])->name('modeles.versions.index');
        Route::post('/modeles/{modele}/versions', [
            ModeleVersionsController::class,
            'store',
        ])->name('modeles.versions.store');

        Route::apiResource('options', OptionController::class);

        // Option Sous Options
        Route::get('/options/{option}/sous-options', [
            OptionSousOptionsController::class,
            'index',
        ])->name('options.sous-options.index');
        Route::post('/options/{option}/sous-options', [
            OptionSousOptionsController::class,
            'store',
        ])->name('options.sous-options.store');

        // Option Versions
        Route::get('/options/{option}/versions', [
            OptionVersionsController::class,
            'index',
        ])->name('options.versions.index');
        Route::post('/options/{option}/versions/{version}', [
            OptionVersionsController::class,
            'store',
        ])->name('options.versions.store');
        Route::delete('/options/{option}/versions/{version}', [
            OptionVersionsController::class,
            'destroy',
        ])->name('options.versions.destroy');

        Route::apiResource('sous-options', SousOptionController::class);

        Route::apiResource('users', UserController::class);

        Route::apiResource('clients', ClientController::class);

        Route::apiResource('feedbacks', FeedbackController::class);
    });
