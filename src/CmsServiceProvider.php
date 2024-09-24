<?php

namespace Newnet\Cms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Newnet\Cms\Facades\PageLayout;
use Newnet\Cms\Listeners\CreateHomePageListener;
use Newnet\Cms\MenuBuilders\CategoryMenuBuilder;
use Newnet\Cms\MenuBuilders\PageMenuBuilder;
use Newnet\Cms\Models\Category;
use Newnet\Cms\Models\Page;
use Newnet\Cms\Models\Post;
use Newnet\Cms\Repositories\CategoryRepositoryInterface;
use Newnet\Cms\Repositories\Eloquent\CategoryRepository;
use Newnet\Cms\Repositories\Eloquent\PageRepository;
use Newnet\Cms\Repositories\Eloquent\PostRepository;
use Newnet\Cms\Repositories\PageRepositoryInterface;
use Newnet\Cms\Repositories\PostRepositoryInterface;
use Newnet\Core\Events\NewnetInstalled;
use Newnet\Module\Support\BaseModuleServiceProvider;

class CmsServiceProvider extends BaseModuleServiceProvider
{
    public function getModuleNamespace()
    {
        return 'cms';
    }

    public function register()
    {
        parent::register();

        $this->app->singleton(PageRepositoryInterface::class, function () {
            return new PageRepository(new Page());
        });

        $this->app->singleton(PostRepositoryInterface::class, function () {
            return new PostRepository(new Post());
        });

        $this->app->singleton(CategoryRepositoryInterface::class, function () {
            return new CategoryRepository(new Category());
        });

        $this->app->singleton('module.cms.page-layout', function () {
            return new PageLayoutGroup();
        });

        AliasLoader::getInstance()->alias('PageLayout', PageLayout::class);

        require_once __DIR__.'/../helpers/helpers.php';
    }

    public function boot()
    {
        parent::boot();

        PageLayout::add('home', __('cms::page.layouts.home'), 'index');

        Event::listen(NewnetInstalled::class, CreateHomePageListener::class);
    }

    public function registerFrontendMenuBuilders()
    {
        \FrontendMenuBuilder::add(PageMenuBuilder::class);
        \FrontendMenuBuilder::add(CategoryMenuBuilder::class);
    }
}
