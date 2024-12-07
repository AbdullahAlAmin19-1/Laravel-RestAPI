<?php

use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sign-up', [UserController::class, 'signUp']);
Route::post('/login', [UserController::class, 'logIn']);
Route::get('/logout', [UserController::class, 'logOut']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('/user-update/{id}', [UserController::class, 'update']);
    Route::get('/user', [UserController::class, 'showDetails']);
    Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole']);
    Route::get('/users/{id}/permissions', [UserController::class, 'permissions']);
});

// Route::get('/users', [UserController::class, 'index']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);
// Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole']);
// Route::get('/users/{id}/permissions', [UserController::class, 'permissions']);
