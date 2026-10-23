<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FareRouteController;
use App\Http\Controllers\Api\QueueEntryController;
use App\Http\Controllers\Api\TerminalController;
use Illuminate\Support\Facades\Route;
Route::prefix('auth')->group(function(){ Route::post('/register',[AuthController::class,'register']); Route::post('/login',[AuthController::class,'login']); Route::middleware('auth:sanctum')->group(function(){ Route::get('/me',[AuthController::class,'me']); Route::post('/logout',[AuthController::class,'logout']); }); });
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/dashboard',DashboardController::class);
    Route::apiResource('terminals',TerminalController::class)->only(['index','show']);
    Route::apiResource('fare-routes',FareRouteController::class)->only(['index','show']);
    Route::apiResource('queue-entries',QueueEntryController::class);
    Route::middleware('role:admin')->group(function(){ Route::apiResource('terminals',TerminalController::class)->except(['index','show']); Route::apiResource('fare-routes',FareRouteController::class)->except(['index','show']); });
});
