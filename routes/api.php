<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

Route::post('/register', [AuthController::class, 'register'])->name('api.register');

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
})->name('api.logout');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('api.user');

Route::middleware('auth:sanctum')->get('/tasks', [TaskController::class, 'getAll'])->name('api.tasks');
Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'post'])->name('api.tasks.post');
Route::middleware('auth:sanctum')->put('/tasks/{id}', [TaskController::class, 'put'])->name('api.tasks.put');
Route::middleware('auth:sanctum')->delete('/tasks/{id}', [TaskController::class, 'delete'])->name('api.tasks.delete');

Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
