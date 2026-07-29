<?php
return [
    'model_name' => 'Trang',

    'name'         => 'Tiêu đề',
    'slug'         => 'Tiêu đề không dấu',
    'page_layout'  => 'Page Layout',
    'description'  => 'Mô',
    'content'      => 'Nội dung',
    'is_active'    => 'Kích hoạt',
    'author'       => 'Tác giả',
    'image'        => 'Hình ảnh',
    'sort_order'   => 'Sắp xếp',
    'created_at'   => 'Ngày tạo',
    'published_at' => 'Ngày xuất bản',
    'parent'       => 'Trang cha',

    'layouts' => [
        'home' => 'Trang chủ',
        'post_list' => 'Bài viết',
    ],

    'index' => [
        'page_title'    => 'Trang',
        'page_subtitle' => 'Trang',
        'breadcrumb'    => 'Trang',
    ],

    'create' => [
        'page_title'    => 'Thêm trang',
        'page_subtitle' => 'Thêm trang',
        'breadcrumb'    => 'Thêm',
    ],

    'edit' => [
        'page_title'    => 'Sửa trang',
        'page_subtitle' => 'Sửa trang',
        'breadcrumb'    => 'Sửa trang',
    ],

    'notification' => [
        'created' => 'Tạo trang thành công!',
        'updated' => 'Cập nhật trang thành công!',
        'deleted' => 'Xóa trang thành công!',
    ],

    'validation' => [
        'home_url_taken' => 'Ngôn ngữ này đã có một trang khác được gán làm Trang chủ (đường dẫn "/"). Vui lòng đổi Page Layout của trang đó trước khi đặt trang này làm Trang chủ.',
    ],

    'tabs' => [
        'info'      => 'Thông tin chung',
        'seo'       => 'SEO',
        'setting'   => 'Cài đặt',
    ],
];
