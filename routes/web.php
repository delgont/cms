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

        Route::prefix('/account')->group(__DIR__.'/web/account.php');

        Route::prefix('/users')->group(__DIR__.'/web/users.php');

        Route::prefix('/menus')->group(__DIR__.'/web/menus.php');


        

        Route::get('/pages', [PageController::class, 'index'])->name('delgont.pages');
        Route::get('/pages/create', [PageController::class, 'create'])->name('delgont.pages.create');
        Route::post('/pages/create', [PageController::class, 'store'])->name('delgont.pages.store');
        Route::get('/pages/show/{id}', [PageController::class, 'show'])->name('delgont.pages.show');
        Route::get('/pages/edit/{id}', [PageController::class, 'edit'])->name('delgont.pages.edit');
        Route::post('/pages/edit/{id}', [PageController::class, 'update'])->name('delgont.pages.update');
        Route::get('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('delgont.pages.destroy');

        Route::get('/pages/publish/{id}', [PageController::class, 'publish'])->name('delgont.pages.publish');
        Route::get('/pages/unpublish/{id}', [PageController::class, 'unpublish'])->name('delgont.pages.unpublish');




        /**Posts Routes*/
        Route::prefix('/posts')->group(__DIR__.'/web/posts.php');

        /**Templates Routes*/
        Route::prefix('/templates')->group(__DIR__.'/web/templates.php');

       



        Route::get('/commands', [CommandController::class, 'index'])->name('delgont.commands');
        Route::post('/commands/run', [CommandController::class, 'run'])->name('delgont.commands.run');

        Route::get('/categories', [CategoryController::class, 'index'])->name('delgont.categories');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('delgont.categories.store');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('delgont.categories.edit');
        Route::get('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('delgont.categories.destroy');


        /**
         * Files File Routes
         */
        Route::prefix('/files')->group(__DIR__.'/web/files.php');

       


        Route::get('/downloads/create', [DownloadController::class, 'create'])->name('delgont.downloads.create');
        Route::post('/downloads/store', [DownloadController::class, 'store'])->name('delgont.downloads.store');
        Route::get('/downloads/show/{id}', [DownloadController::class, 'show'])->name('delgont.downloads.show');
        Route::get('/downloads/destroy/{id}', [DownloadController::class, 'destroy'])->name('delgont.downloads.destroy');

        Route::get('/downloads/download/{id}', [DownloadController::class, 'download'])->name('delgont.downloads.download');


        Route::get('/', [DashboardController::class, 'index'])->name('delgont.dashboard');

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

            Route::prefix('/account')->group(__DIR__.'/web/account.php');

            Route::get('/users', [UserController::class, 'index']);
            Route::get('/users/create', [UserController::class, 'create']);
            Route::post('/users/store', [UserController::class, 'store']);
            Route::get('/users/{username}/{id}', [UserController::class, 'show']);
            Route::get('/users/edit/{username}/{id}', [UserController::class, 'edit']);
            Route::post('/users/update/{id}', [UserController::class, 'update']);
            Route::get('/users/destroy/{id}', [UserController::class, 'destroy']);
            Route::post('/users/change/password/{id}', [UserController::class, 'changePassword']);
            Route::get('/users/{username}/activitylog', [UserController::class, 'index']);

            Route::get('/pages', [PageController::class, 'index']);
            Route::get('/pages/create', [PageController::class, 'create']);
            Route::post('/pages/create', [PageController::class, 'store']);
            Route::get('/pages/show/{id}', [PageController::class, 'show']);
            Route::get('/pages/edit/{id}', [PageController::class, 'edit']);
            Route::post('/pages/edit/{id}', [PageController::class, 'update']);

            Route::get('/posts', [PostController::class, 'index']);
            Route::get('/posts/create', [PostController::class, 'create']);
            Route::post('/posts/create', [PostController::class, 'store']);
            Route::get('/posts/show/{id}', [PostController::class, 'show']);
            Route::post('/posts/update/{id}', [PostController::class, 'update']);
            Route::get('/posts/destroy/{id}', [PostController::class, 'destroy']);

            Route::get('/posts/trash', [PostTrashController::class, 'index']);
            Route::get('/posts/trash/{id}', [PostTrashController::class, 'show']);

            Route::get('/categories', [CategoryController::class, 'index']);
            Route::post('/categories/store', [CategoryController::class, 'store']);
            Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
            Route::get('/categories/destroy/{id}', [CategoryController::class, 'destroy']);

            Route::get('/', [TestController::class, 'index']);

            Route::get('/system/settings', [SystemSettingController::class, 'index']);



        });
 
    });
 });