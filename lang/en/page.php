<?php
return [
    'model_name' => 'Page',

    'name'         => 'Title',
    'slug'         => 'Slug',
    'page_layout'  => 'Page Layout',
    'description'  => 'Description',
    'content'      => 'Content',
    'is_active'    => 'Active',
    'author'       => 'Author',
    'image'        => 'Image',
    'sort_order'   => 'Sort Order',
    'created_at'   => 'Created At',
    'published_at' => 'Published At',
    'parent'       => 'Parent',

    'layouts' => [
        'home' => 'Home',
        'post_list' => 'Posts',
    ],

    'index' => [
        'page_title'    => 'Page',
        'page_subtitle' => 'Page',
        'breadcrumb'    => 'Page',
    ],

    'create' => [
        'page_title'    => 'Add Page',
        'page_subtitle' => 'Add Page',
        'breadcrumb'    => 'Add',
    ],

    'edit' => [
        'page_title'    => 'Edit Page',
        'page_subtitle' => 'Edit Page',
        'breadcrumb'    => 'Edit',
        'preview'       => 'Preview',
    ],

    'notification' => [
        'created' => 'Page successfully created!',
        'updated' => 'Page successfully updated!',
        'deleted' => 'Page successfully deleted!',
    ],

    'validation' => [
        'home_url_taken' => 'Another page is already set as the Home page ("/") for this language. Please change that page\'s Page Layout before assigning this one as Home.',
    ],

    'tabs' => [
        'info'      => 'Information',
        'seo'       => 'SEO',
        'setting'   => 'Setting',
    ],
];
