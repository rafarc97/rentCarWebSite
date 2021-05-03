<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdController;

Route::get('/',[UserAuthController::class,'login'])->middleware('AlreadyLoggedIn');
Route::get('login',[UserAuthController::class,'login'])->middleware('AlreadyLoggedIn');
Route::get('register',[UserAuthController::class,'register'])->middleware('AlreadyLoggedIn');
Route::post('create',[UserAuthController::class,'create'])->name('auth.create');
Route::post('check',[UserAuthController::class,'check'])->name('auth.check');
//Route::get('menu',[UserAuthController::class,'menu'])->middleware('isLogged');
Route::get('menu', [AdController::class, 'menu'])->name('menu');
Route::get('show/{ad}', [AdController::class, 'show'])->name('show');
Route::get('brand/{name}', [AdController::class, 'brand'])->name('brand');
Route::get('type/{name}', [AdController::class, 'type'])->name('type');
Route::get('logout',[UserAuthController::class,'logout']);
