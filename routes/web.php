<?php

use Illuminate\Support\Facades\Route;

use Delgont\Cms\Http\Controllers\Auth\AuthController;

use Delgont\Cms\Http\Controllers\AdminController;
use Delgont\Cms\Http\Controllers\UserController;

use Delgont\Cms\Http\Controllers\Account\AccountController;
use Delgont\Cms\Http\Controllers\Account\ActivityLogController;
use Delgont\Cms\Http\Controllers\Account\AccountSettingController;
use Delgont\Cms\Http\Controllers\Account\AccountNotificationsController;
use Delgont\Cms\Http\Controllers\Account\PasswordController;

use Delgont\Cms\Http\Controllers\Page\PageController;

use Delgont\Cms\Http\Controllers\Menu\MenuController;
use Delgont\Cms\Http\Controllers\Menu\MenuItemController;

use Delgont\Cms\Http\Controllers\Template\TemplateController;

use Delgont\Cms\Http\Controllers\Post\PostController;
use Delgont\Cms\Http\Controllers\Post\PostTypeController;
use Delgont\Cms\Http\Controllers\Post\PostCommentController;
use Delgont\Cms\Http\Controllers\Post\PostTrashController;
use Delgont\Cms\Http\Controllers\Post\PostCategoryController;

use Delgont\Cms\Http\Controllers\Category\CategoryController;

use Delgont\Cms\Http\Controllers\DashboardController;

use Delgont\Cms\Http\Controllers\Auth\ForgotPasswordController;

use Delgont\Cms\Http\Controllers\System\SystemSettingController;
use Delgont\Cms\Http\Controllers\Settings\GeneralSettingsController;

use Delgont\Cms\Http\Controllers\Download\DownloadController;

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

        Route::get('/account', [AccountController::class, 'index'])->name('delgont.account');

        Route::get('/account/password', [PasswordController::class, 'index'])->name('delgont.account.password');
        Route::post('/account/password/update', [PasswordController::class, 'update'])->name('delgont.account.password.update');

        Route::post('/account/change/avator', [AccountController::class, 'updateAvator'])->name('delgont.account.change.avator');
        Route::get('/account/settings', [AccountSettingController::class, 'index'])->name('delgont.account.settings');

        Route::get('/account/activitylog', [ActivityLogController::class, 'index'])->name('delgont.account.activitylog');
        Route::get('/account/activitylog/{id}', [ActivityLogController::class, 'destroy'])->name('delgont.account.activitylog.destroy');

        Route::get('/account/notifications', [AccountNotificationsController::class, 'index'])->name('delgont.account.notifications');
        Route::get('/account/notifications/count', [AccountNotificationsController::class, 'count'])->name('delgont.account.notifications.count');
        Route::get('/account/notifications/{id}', [AccountNotificationsController::class, 'show'])->name('delgont.account.notifications.show');
        Route::get('/account/notifications/destroy/{id}', [AccountNotificationsController::class, 'destroy'])->name('delgont.account.notifications.destroy');



        Route::get('/users/admins', [AdminController::class, 'index'])->name('delgont.users.admins');
        Route::get('/admins/add-new', [AdminController::class, 'create'])->name('delgont.admins.create');
        Route::post('/admins/add-new', [AdminController::class, 'store'])->name('delgont.admins.store');

        Route::get('/users', [UserController::class, 'index'])->name('delgont.users');
        Route::get('/users/create', [UserController::class, 'create'])->name('delgont.users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('delgont.users.store');
        Route::get('/users/{username}', [UserController::class, 'show'])->name('delgont.users.show');
        Route::get('/users/edit/{username}/{id}', [UserController::class, 'edit'])->name('delgont.users.edit');
        Route::post('/users/update/{id}', [UserController::class, 'update'])->name('delgont.users.update');
        Route::get('/users/destroy/{id}', [UserController::class, 'destroy'])->name('delgont.users.destroy');
        Route::post('/users/change/password/{id}', [UserController::class, 'changePassword'])->name('delgont.users.change.password');
        Route::get('/users/{username}/activitylog', [UserController::class, 'index'])->name('delgont.admins.activitylog');

        Route::get('/pages', [PageController::class, 'index'])->name('delgont.pages');
        Route::get('/pages/create', [PageController::class, 'create'])->name('delgont.pages.create');
        Route::post('/pages/create', [PageController::class, 'store'])->name('delgont.pages.store');
        Route::get('/pages/show/{id}', [PageController::class, 'show'])->name('delgont.pages.show');
        Route::get('/pages/edit/{id}', [PageController::class, 'edit'])->name('delgont.pages.edit');
        Route::post('/pages/edit/{id}', [PageController::class, 'update'])->name('delgont.pages.update');
        Route::get('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('delgont.pages.destroy');

        Route::get('/pages/publish/{id}', [PageController::class, 'publish'])->name('delgont.pages.publish');
        Route::get('/pages/unpublish/{id}', [PageController::class, 'unpublish'])->name('delgont.pages.unpublish');



        Route::get('/menus', [MenuController::class, 'index'])->name('delgont.menus');
        Route::get('/menus/{id}', [MenuController::class, 'show'])->name('delgont.menus.menu.show');

        Route::post('/menuitem/store', [MenuItemController::class, 'store'])->name('delgont.menus.menuitem.store');
        Route::get('/menuitem/destroy/{id}', [MenuItemController::class, 'destroy'])->name('delgont.menus.menuitem.destroy');

        Route::get('/posts', [PostController::class, 'index'])->name('delgont.posts');
        Route::get('/posts/create', [PostController::class, 'create'])->name('delgont.posts.create');
        Route::get('/posts/create/duplicate/{id}', [PostController::class, 'duplicate'])->name('delgont.posts.create.duplicate');
        Route::post('/posts/create', [PostController::class, 'store'])->name('delgont.posts.store');
        Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('delgont.posts.show');
        Route::get('/posts/edit/{id}', [PostController::class, 'edit'])->name('delgont.posts.edit');
        Route::post('/posts/update/{id}', [PostController::class, 'update'])->name('delgont.posts.update');
        Route::get('/posts/destroy/{id}', [PostController::class, 'destroy'])->name('delgont.posts.destroy');

        Route::get('/posts/publish/{id}', [PostController::class, 'publish'])->name('delgont.posts.publish');
        Route::get('/posts/unpublish/{id}', [PostController::class, 'unpublish'])->name('delgont.posts.unpublish');


        Route::post('/posts/edit/featuredimage/{id}', [PostController::class, 'editFeaturedImage'])->name('delgont.posts.edit.featuredimage');
        Route::post('/posts/destroy/featuredimage/{id}', [PostController::class, 'destroyFeaturedImage'])->name('delgont.posts.destroy.featuredimage');


        Route::get('/posts/trash', [PostTrashController::class, 'index'])->name('delgont.posts.trash');
        Route::get('/posts/trash/{id}', [PostTrashController::class, 'show'])->name('delgont.posts.trash.show');
        Route::get('/posts/trash/destroy/{id}', [PostTrashController::class, 'destroy'])->name('delgont.posts.trash.destroy');
        Route::get('/posts/trash/restore/{id}', [PostTrashController::class, 'restore'])->name('delgont.posts.trash.restore');

        Route::post('/posts/search', [PostController::class, 'search'])->name('delgont.posts.search');

        Route::get('/posts/posttypes', [PostTypeController::class, 'index'])->name('delgont.posts.posttypes');
        Route::get('/posts/posttypes/create', [PostTypeController::class, 'create'])->name('delgont.posts.posttypes.create');
        Route::post('/posts/posttypes/store', [PostTypeController::class, 'store'])->name('delgont.posts.posttypes.store');
        Route::get('/posts/posttypes/destroy/{id}', [PostTypeController::class, 'destroy'])->name('delgont.posts.posttypes.destroy');

        Route::get('/posts/categories', [PostCategoryController::class, 'index'])->name('delgont.posts.categories');



        Route::get('/posts/{id}/comments', [PostCommentController::class, 'index'])->name('delgont.posts.comments');
        Route::post('/posts/{id}/comments', [PostCommentController::class, 'store'])->name('delgont.posts.comments.store');
        Route::post('/posts/comment/update/{comment_id}', [PostCommentController::class, 'update'])->name('delgont.posts.comments.update');

        Route::get('/templates', [TemplateController::class, 'index'])->name('delgont.templates');
        Route::get('/templates/{id}', [TemplateController::class, 'show'])->name('delgont.templates.show');
        Route::post('/templates/disable/{id}', [TemplateController::class, 'disable'])->name('delgont.templates.disable');
        Route::post('/templates/enable/{id}', [TemplateController::class, 'disable'])->name('delgont.templates.enable');



        Route::get('/categories', [CategoryController::class, 'index'])->name('delgont.categories');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('delgont.categories.store');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('delgont.categories.edit');
        Route::get('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('delgont.categories.destroy');

        Route::get('/downloads', [DownloadController::class, 'index'])->name('delgont.downloads');
        Route::get('/downloads/create', [DownloadController::class, 'create'])->name('delgont.downloads.create');
        Route::post('/downloads/store', [DownloadController::class, 'store'])->name('delgont.downloads.store');
        Route::get('/downloads/show/{id}', [DownloadController::class, 'show'])->name('delgont.downloads.show');
        Route::get('/downloads/destroy/{id}', [DownloadController::class, 'destroy'])->name('delgont.downloads.destroy');

        Route::get('/downloads/download/{id}', [DownloadController::class, 'download'])->name('delgont.downloads.download');


        Route::get('/', [DashboardController::class, 'index'])->name('delgont.dashboard');

        Route::get('/settings/general', [GeneralSettingsController::class, 'index'])->name('delgont.settings.general');
        Route::post('/settings/general', [GeneralSettingsController::class, 'store']);


        Route::post('/test', [TestController::class, 'index'])->name('test');

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

            Route::get('/account', [AccountController::class, 'index']);
            Route::get('/account/activitylog', [AccountController::class, 'activityLog']);
            Route::post('/account/change/password', [AccountController::class, 'changePassword']);
            Route::post('/account/change/avator', [AccountController::class, 'updateAvator']);
            Route::get('/account/settings', [AccountSettingController::class, 'index']);

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