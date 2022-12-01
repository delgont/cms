<?php

use Illuminate\Support\Facades\Route;
use Delgont\Cms\Http\Controllers\Account\AccountController;
use Delgont\Cms\Http\Controllers\Account\ActivityLogController;
use Delgont\Cms\Http\Controllers\Account\AccountSettingController;
use Delgont\Cms\Http\Controllers\Account\AccountNotificationsController;

Route::get('/', [AccountController::class, 'index'])->name('delgont.account');
Route::get('/password', [PasswordController::class, 'index'])->name('delgont.account.password');
Route::post('/password/update', [PasswordController::class, 'update'])->name('delgont.account.password.update');
Route::post('/change/avator', [AccountController::class, 'updateAvator'])->name('delgont.account.change.avator');
Route::get('/settings', [AccountSettingController::class, 'index'])->name('delgont.account.settings');
Route::get('/activitylog', [ActivityLogController::class, 'index'])->name('delgont.account.activitylog');
Route::get('/activitylog/{id}', [ActivityLogController::class, 'destroy'])->name('delgont.account.activitylog.destroy');
Route::get('/notifications', [AccountNotificationsController::class, 'index'])->name('delgont.account.notifications');
Route::get('/notifications/count', [AccountNotificationsController::class, 'count'])->name('delgont.account.notifications.count');
Route::get('/notifications/{id}', [AccountNotificationsController::class, 'show'])->name('delgont.account.notifications.show');
Route::get('/notifications/destroy/{id}', [AccountNotificationsController::class, 'destroy'])->name('delgont.account.notifications.destroy');