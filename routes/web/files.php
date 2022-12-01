<?php

use Illuminate\Support\Facades\Route;
use Delgont\Cms\Http\Controllers\File\FileController;

Route::get('/', [FileController::class, 'index'])->name('delgont.files');
Route::get('/create', [FileController::class, 'create'])->name('delgont.files.create');
Route::post('/store', [FileController::class, 'store'])->name('delgont.files.store');
Route::get('/show/{id}', [FileController::class, 'show'])->name('delgont.files.show');
Route::get('/edit/{id}', [FileController::class, 'edit'])->name('delgont.files.edit');
Route::post('/update/{id}', [FileController::class, 'update'])->name('delgont.files.update');
Route::get('/destroy/{id}', [FileController::class, 'destroy'])->name('delgont.files.destroy');
Route::get('/search/{query}', [FileController::class, 'search'])->name('delgont.files.search');
Route::get('/of/category/{category}', [FileController::class, 'ofCategory'])->name('delgont.files.of.category');
Route::get('/of/group/{group}', [FileController::class, 'ofGroup'])->name('delgont.files.of.group');