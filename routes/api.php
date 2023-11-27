<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\UserController as UserControllerv1;
use App\Http\Controllers\API\v1\LoginController as Loginv1;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::resource('users', UserControllerv1::class )->names('api.users')->only(['index', 'show', 'store', 'update', 'destroy']);            
    });
    
    Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
        // Revoke all tokens and revoke the token that was used to authenticate the current request
        $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'User logout with success'], 200);
    });

    Route::post('login',[Loginv1::class, 'store'])->name('api.login');
});
