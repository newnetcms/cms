<?php

namespace Newnet\Cms;

use Illuminate\Foundation\AliasLoader;
use Newnet\Cms\Facades\PageLayout;
use Newnet\Cms\MenuBuilders\CategoryMenuBuilder;
use Newnet\Cms\MenuBuilders\PageMenuBuilder;
use Newnet\Menu\Facades\FrontendMenuBuilder;
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

        $this->app->singleton('module.cms.page-layout', function () {
            return new PageLayoutGroup();
        });

        AliasLoader::getInstance()->alias('PageLayout', PageLayout::class);
    }

    public function boot()
    {
        parent::boot();

        PageLayout::add('home', __('cms::page.layouts.home'), 'index');
        PageLayout::add('post_list', __('cms::page.layouts.post_list'));
    }

    public function registerFrontendMenuBuilders()
    {
        FrontendMenuBuilder::add(PageMenuBuilder::class);
        FrontendMenuBuilder::add(CategoryMenuBuilder::class);
    }
}
