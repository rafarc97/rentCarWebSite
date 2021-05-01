<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;


Route::get('/',[UserAuthController::class,'login'])->middleware('AlreadyLoggedIn');
Route::get('login',[UserAuthController::class,'login'])->middleware('AlreadyLoggedIn');
Route::get('register',[UserAuthController::class,'register'])->middleware('AlreadyLoggedIn');
Route::post('create',[UserAuthController::class,'create'])->name('auth.create');
Route::post('check',[UserAuthController::class,'check'])->name('auth.check');
Route::get('menu',[UserAuthController::class,'menu'])->middleware('isLogged');
Route::get('logout',[UserAuthController::class,'logout']);
