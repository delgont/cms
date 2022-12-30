<?php

use Illuminate\Support\Facades\Route;

use Delgont\Cms\Http\Controllers\Auth\AuthController;

use Delgont\Cms\Http\Controllers\AdminController;
use Delgont\Cms\Http\Controllers\UserController;

use Delgont\Cms\Http\Controllers\Account\PasswordController;

use Delgont\Cms\Http\Controllers\Page\PageController;

use Delgont\Cms\Http\Controllers\Menu\MenuController;
use Delgont\Cms\Http\Controllers\Menu\MenuItemController;




use Delgont\Cms\Http\Controllers\Category\CategoryController;

use Delgont\Cms\Http\Controllers\Command\CommandController;
use Delgont\Cms\Http\Controllers\Console\ConsoleController;

use Delgont\Cms\Http\Controllers\DashboardController;

use Delgont\Cms\Http\Controllers\Auth\ForgotPasswordController;

use Delgont\Cms\Http\Controllers\System\SystemSettingController;
use Delgont\Cms\Http\Controllers\Settings\GeneralSettingsController;


use Delgont\Cms\Http\Controllers\TestController;


/**
 * Web Routes
 */
Route::group(['prefix' => config('delgont.route_prefix', 'dashboard'), 'middleware' => 'web'], function(){

    Route::group(['middleware' => 'guest:auth'], function(){
        Route::get('/login', [AuthController::class, 'index'])->name('delgont.login');
        Route::post('/login', [AuthController::class, 'login'])->name('delgont.login');
        Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('delgont.password.resetEmailForm');
        Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('delgont.password.reset.link');
    });

    Route::group(['middleware' => ['auth']], function(){

        Route::post('/logout', [AuthController::class, 'logout'])->name('delgont.logout');

        Route::get('/', [DashboardController::class, 'index'])->name('delgont.dashboard');

        Route::prefix('/account')->group(__DIR__.'/web/account.php');

        Route::prefix('/users')->group(__DIR__.'/web/users.php');

        Route::prefix('/menus')->group(__DIR__.'/web/menus.php');

        /**Posts Routes*/
        Route::prefix('/posts')->group(__DIR__.'/web/posts.php');

        /** Templates Routes */
        Route::prefix('/templates')->group(__DIR__.'/web/templates.php');

        Route::get('/console', [ConsoleController::class, 'index'])->name('delgont.console.commands');
        Route::post('/console/run', [ConsoleController::class, 'run'])->name('delgont.console.commands.run');

        Route::get('/commands', [CommandController::class, 'index'])->name('delgont.commands');
        Route::post('/commands/run', [CommandController::class, 'run'])->name('delgont.commands.run');

        Route::get('/categories', [CategoryController::class, 'index'])->name('delgont.categories');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('delgont.categories.store');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('delgont.categories.edit');
        Route::get('/categories/show/{id}', [CategoryController::class, 'show'])->name('delgont.categories.show');
        Route::get('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('delgont.categories.destroy');


        Route::get('/settings/general', [GeneralSettingsController::class, 'index'])->name('delgont.settings.general');
        Route::post('/settings/general', [GeneralSettingsController::class, 'store']);


        Route::get('/test', [TestController::class, 'index'])->name('test');
        Route::get('/test/store', [TestController::class, 'store'])->name('test.store');
        Route::get('/test/show/{id}', [TestController::class, 'show'])->name('test.show');
        Route::get('/test/update/{id}', [TestController::class, 'show'])->name('test.show');
        Route::get('/test/delete/{id}', [TestController::class, 'destroy'])->name('test.destroy');

    });

});


/**
 * API Routes
 */
Route::group(['prefix' => 'api'], function(){
    Route::group(['prefix' => config('delgont.route_prefix', 'dashboard')], function(){

        Route::group(['middleware' => ['api','guest:api']], function(){
            Route::post('/login', [AuthController::class, 'apiLogin']);
        });
 
        Route::group(['middleware' => ['api','auth:api']], function(){
            
        });
 
    });
 });