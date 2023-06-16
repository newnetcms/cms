<?php

use Newnet\Cms\CmsAdminMenuKey;

AdminMenu::addItem(__('cms::module.module_name'), [
    'id' => CmsAdminMenuKey::CONTENT,
    'icon' => 'fas fa-newspaper',
    'order' => 4000,
]);

AdminMenu::addItem(__('cms::post.model_name'), [
    'id' => CmsAdminMenuKey::POST,
    'parent' => CmsAdminMenuKey::CONTENT,
    'route' => 'cms.admin.post.index',
    'icon' => 'fas fa-pen-alt',
    'order' => 1,
]);

AdminMenu::addItem(__('cms::category.model_name'), [
    'id' => CmsAdminMenuKey::CATEGORY,
    'parent' => CmsAdminMenuKey::CONTENT,
    'route' => 'cms.admin.category.index',
    'icon' => 'fas fa-folder-open',
    'order' => 2,
]);

AdminMenu::addItem(__('cms::page.model_name'), [
    'id' => CmsAdminMenuKey::PAGE,
    'parent' => CmsAdminMenuKey::CONTENT,
    'route' => 'cms.admin.page.index',
    'icon' => 'fas fa-copy',
    'order' => 3,
]);
