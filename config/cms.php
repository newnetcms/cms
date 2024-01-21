<?php

return [
    'page' => [
        'page_layout' => [
            'options' => [
                'default'   => 'Default',
                'home'      => 'Home',
                'about'     => 'About',
                'contact'   => 'Contact',
                'post_list' => 'Post List',
            ],
            'default' => 'default',
        ],
    ],

    'item_per_page' => env('CMS_ITEM_PER_PAGE', 20),

    'media_manager' => true
];
