<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TodoController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
  Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
  Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
  Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
  Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
});
