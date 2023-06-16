<?php

use Newnet\Cms\Http\Controllers\Admin\PageController;
use Newnet\Cms\Http\Controllers\Admin\PostController;
use Newnet\Cms\Http\Controllers\Admin\CategoryController;

Route::prefix('cms')
    ->name('cms.admin.')
    ->middleware('admin.acl')
    ->group(function () {
        Route::resource('page', PageController::class);
        Route::resource('post', PostController::class);
        Route::resource('category', CategoryController::class);
    });

Route::prefix('cms/page')
    ->group(function () {
        Route::get('{id}/move-up', [PageController::class, 'moveUp'])
            ->name('cms.admin.page.move-up')
            ->middleware('admin.can:menu.page.edit');

        Route::get('{id}/move-down', [PageController::class, 'moveDown'])
            ->name('cms.admin.page.move-down')
            ->middleware('admin.can:menu.page.edit');
    });

Route::prefix('cms/category')
    ->group(function () {
        Route::get('{id}/move-up', [CategoryController::class, 'moveUp'])
            ->name('cms.admin.category.move-up')
            ->middleware('admin.can:menu.category.edit');

        Route::get('{id}/move-down', [CategoryController::class, 'moveDown'])
            ->name('cms.admin.category.move-down')
            ->middleware('admin.can:menu.category.edit');
    });
