<?php

use Illuminate\Support\Facades\Route;
use Delgont\Cms\Http\Controllers\Post\PostController;
use Delgont\Cms\Http\Controllers\Post\PostTypeController;
use Delgont\Cms\Http\Controllers\Post\PostCommentController;
use Delgont\Cms\Http\Controllers\Post\PostTrashController;
use Delgont\Cms\Http\Controllers\Post\PostCategoryController;


Route::get('/', [PostController::class, 'index'])->name('delgont.posts');
Route::get('/create', [PostController::class, 'create'])->name('delgont.posts.create');
Route::get('/create/duplicate/{id}', [PostController::class, 'duplicate'])->name('delgont.posts.create.duplicate');
Route::post('/create', [PostController::class, 'store'])->name('delgont.posts.store');
Route::get('/show/{id}', [PostController::class, 'show'])->name('delgont.posts.show');
Route::get('/edit/{id}', [PostController::class, 'edit'])->name('delgont.posts.edit');
Route::post('/update/{id}', [PostController::class, 'update'])->name('delgont.posts.update');
Route::get('/destroy/{id}', [PostController::class, 'destroy'])->name('delgont.posts.destroy');

Route::get('/publish/{id}', [PostController::class, 'publish'])->name('delgont.posts.publish');
Route::get('/unpublish/{id}', [PostController::class, 'unpublish'])->name('delgont.posts.unpublish');


Route::post('/edit/featuredimage/{id}', [PostController::class, 'editFeaturedImage'])->name('delgont.posts.edit.featuredimage');
Route::post('/destroy/featuredimage/{id}', [PostController::class, 'destroyFeaturedImage'])->name('delgont.posts.destroy.featuredimage');


Route::get('/trash', [PostTrashController::class, 'index'])->name('delgont.posts.trash');
Route::get('/trash/{id}', [PostTrashController::class, 'show'])->name('delgont.posts.trash.show');
Route::get('/trash/destroy/{id}', [PostTrashController::class, 'destroy'])->name('delgont.posts.trash.destroy');
Route::get('/trash/restore/{id}', [PostTrashController::class, 'restore'])->name('delgont.posts.trash.restore');

Route::post('/search', [PostController::class, 'search'])->name('delgont.posts.search');

Route::get('/posttypes', [PostTypeController::class, 'index'])->name('delgont.posts.posttypes');
Route::get('/posttypes/create', [PostTypeController::class, 'create'])->name('delgont.posts.posttypes.create');
Route::post('/posttypes/store', [PostTypeController::class, 'store'])->name('delgont.posts.posttypes.store');
Route::get('/posttypes/destroy/{id}', [PostTypeController::class, 'destroy'])->name('delgont.posts.posttypes.destroy');

Route::get('/categories', [PostCategoryController::class, 'index'])->name('delgont.posts.categories');



Route::get('/{id}/comments', [PostCommentController::class, 'index'])->name('delgont.posts.comments');
Route::post('/{id}/comments', [PostCommentController::class, 'store'])->name('delgont.posts.comments.store');
Route::post('/comment/update/{comment_id}', [PostCommentController::class, 'update'])->name('delgont.posts.comments.update');