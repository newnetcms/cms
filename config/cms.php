<?php

return [
    'page' => [
        'page_layout' => [
            'options' => [
//                'default'   => 'Default',
//                'home'      => 'Home',
//                'about'     => 'About',
//                'contact'   => 'Contact',
//                'post_list' => 'Post List',
            ],
            'default' => 'default',
        ],
    ],

    'item_per_page' => env('CMS_ITEM_PER_PAGE', 20),

    'media_manager' => true,

    'enable_post_type' => env('CMS_ENABLE_POST_TYPE', false),

    'enable_manage_own' => env('CMS_ENABLE_MANAGE_OWN', false),
    // Thời hạn (phút) của URL xem trước bài viết/trang chưa xuất bản, mặc định 7 ngày
    'preview_lifetime' => env('CMS_PREVIEW_LIFETIME', 10080),
];
