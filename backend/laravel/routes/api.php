<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
Route::get('/users/{id}', [UserController::class, 'findById']);