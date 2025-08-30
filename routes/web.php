<?php

use Newnet\Cms\Http\Controllers\Web\PageController;
use Newnet\Cms\Http\Controllers\Web\PostController;
use Newnet\Cms\Http\Controllers\Web\CategoryController;

Route::middleware(['seo.internal.access'])
    ->group(function () {
        Route::get('cms/page/{id}', [PageController::class, 'detail'])->name('cms.web.page.detail');
        Route::get('cms/post/{id}', [PostController::class, 'detail'])->name('cms.web.post.detail');
        Route::get('cms/category/{id}', [CategoryController::class, 'detail'])->name('cms.web.category.detail');
    });
