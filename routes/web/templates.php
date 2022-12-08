<?php

use Illuminate\Support\Facades\Route;
use Delgont\Cms\Http\Controllers\Template\TemplateController;
use Delgont\Cms\Http\Controllers\Template\SectionController;

Route::get('/', [TemplateController::class, 'index'])->name('delgont.templates');
Route::get('/show/{id}', [TemplateController::class, 'show'])->name('delgont.templates.show');
Route::post('/disable/{id}', [TemplateController::class, 'disable'])->name('delgont.templates.disable');
Route::post('/enable/{id}', [TemplateController::class, 'disable'])->name('delgont.templates.enable');

Route::get('/sections', [SectionController::class, 'index'])->name('delgont.templates.sections');
Route::get('/sections/show/{id}', [SectionController::class, 'show'])->name('delgont.templates.sections.show');
Route::post('/sections/settings/update/{id}', [SectionController::class, 'updateSettings'])->name('delgont.templates.sections.settings.update');
