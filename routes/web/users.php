<?php

use Illuminate\Support\Facades\Route;

use Delgont\Cms\Http\Controllers\AdminController;
use Delgont\Cms\Http\Controllers\UserController;

use Delgont\Cms\Http\Controllers\TestController;

Route::get('/admins', [AdminController::class, 'index'])->name('delgont.users.admins');
Route::get('/add-new', [AdminController::class, 'create'])->name('delgont.admins.create');
Route::post('/add-new', [AdminController::class, 'store'])->name('delgont.admins.store');

Route::get('/', [UserController::class, 'index'])->name('delgont.users');
Route::get('/create', [UserController::class, 'create'])->name('delgont.users.create');
Route::post('/store', [UserController::class, 'store'])->name('delgont.users.store');
Route::get('/{username}', [UserController::class, 'show'])->name('delgont.users.show');
Route::get('/edit/{username}/{id}', [UserController::class, 'edit'])->name('delgont.users.edit');
Route::post('/update/{id}', [UserController::class, 'update'])->name('delgont.users.update');
Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('delgont.users.destroy');
Route::post('//change/password/{id}', [UserController::class, 'changePassword'])->name('delgont.users.change.password');
Route::get('/{username}/activitylog', [UserController::class, 'index'])->name('delgont.admins.activitylog');