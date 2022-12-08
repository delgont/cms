<?php

use Illuminate\Support\Facades\Route;

use Delgont\Cms\Http\Controllers\Menu\MenuController;
use Delgont\Cms\Http\Controllers\Menu\MenuItemController;


Route::get('/', [MenuController::class, 'index'])->name('delgont.menus');
Route::get('/{id}', [MenuController::class, 'show'])->name('delgont.menus.menu.show');
Route::post('/menuitem/store', [MenuItemController::class, 'store'])->name('delgont.menus.menuitem.store');
Route::get('/menuitem/destroy/{id}', [MenuItemController::class, 'destroy'])->name('delgont.menus.menuitem.destroy');