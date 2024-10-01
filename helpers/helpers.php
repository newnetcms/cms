<?php

use Newnet\Cms\Models\Category;
use Newnet\Cms\Models\Page;
use Newnet\Cms\Models\Post;
use Newnet\Cms\Repositories\CategoryRepositoryInterface;
use Newnet\Cms\Repositories\PostRepositoryInterface;

if (!function_exists('get_page_layout_options')) {
    /**
     * Get Page Layout Options
     *
     * @return array
     */
    function get_page_layout_options()
    {
        return PageLayout::toOptions();
    }
}

if (!function_exists('get_page_layout_label')) {
    /**
     * Get Page Layout Label
     *
     * @param $key
     * @return string
     */
    function get_page_layout_label($key)
    {
        return PageLayout::getLabel($key);
    }
}

if (!function_exists('get_category_parent_options')) {
    /**
     * Get Category Parent Options
     *
     * @return array
     */
    function get_category_parent_options()
    {
        $options = [];

        $categoryTreeList = Category::defaultOrder()->withDepth()->get()->toFlatTree();
        foreach ($categoryTreeList as $item) {
            $options[] = [
                'value' => $item->id,
                'label' => trim(str_pad('', $item->depth * 3, '-')).' '.$item->name,
            ];
        }

        return $options;
    }
}

if (!function_exists('get_page_parent_options')) {
    /**
     * Get Page Parent Options
     *
     * @return array
     */
    function get_page_parent_options()
    {
        $options = [];

        $pageTreeList = Page::defaultOrder()->withDepth()->get()->toFlatTree();
        foreach ($pageTreeList as $item) {
            $options[] = [
                'value' => $item->id,
                'label' => trim(str_pad('', $item->depth * 3, '-')).' '.$item->name,
            ];
        }

        return $options;
    }
}

if (!function_exists('get_page_menu_builder_options')) {
    function get_page_menu_builder_options()
    {
        return get_page_parent_options();
    }
}

if (!function_exists('get_cms_category_menu_builder_options')) {
    function get_cms_category_menu_builder_options()
    {
        return get_category_parent_options();
    }
}

if (!function_exists('get_cms_setting_page_options')) {
    function get_cms_setting_page_options()
    {
        return get_page_parent_options();
    }
}

if (!function_exists('get_cms_last_post')) {
    /**
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function get_cms_last_post($limit = 20)
    {
        return app(PostRepositoryInterface::class)->lastPost($limit);
    }
}

if (!function_exists('get_cms_post_top_view')) {
    /**
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function get_cms_post_top_view($limit = 20)
    {
        return app(PostRepositoryInterface::class)->topView($limit);
    }
}

if (!function_exists('get_cms_author')) {
    /**
     * @param $item
     * @return \Newnet\Acl\Models\Admin
     */
    function get_cms_author($item)
    {
        return object_get($item, 'author');
    }
}

if (!function_exists('get_cms_read_time_seconds')) {
    function get_cms_read_time_seconds($content)
    {
        if ($content instanceof Post) {
            $content = $content->content;
        }

        $wordnum = str_word_count(strip_tags($content));

        $avgtime = 120;

        return floor((int)$wordnum / $avgtime) * 60;
    }
}

if (!function_exists('get_cms_read_time')) {
    function get_cms_read_time($content)
    {
        $seconds = get_cms_read_time_seconds($content);

        $minutes = floor($seconds / 60);

        if ($minutes < 1) {
            return __('less than 1 minute');
        } else {
            return trans_choice(':min minute|:min minutes', $minutes, [
                'min' => $minutes
            ]);
        }
    }
}

if (!function_exists('get_cms_categories_root')) {
    function get_cms_categories_root()
    {
        return app(CategoryRepositoryInterface::class)->listRoot();
    }
}

if (!function_exists('get_cms_count_posts')) {
    function get_cms_count_posts()
    {
        return app(PostRepositoryInterface::class)->count();
    }
}

if (!function_exists('get_cms_count_posts_in_category')) {
    function get_cms_count_posts_in_category(Category $category)
    {
        return app(PostRepositoryInterface::class)->countInCategory($category);
    }
}

if (!function_exists('get_cms_sticky_post')) {
    function get_cms_sticky_post($limit)
    {
        return app(PostRepositoryInterface::class)->stickyPost($limit);
    }
}

if (!function_exists('get_cms_related_posts')) {
    function get_cms_related_posts(Post $post, $limit = 10)
    {
        return app(PostRepositoryInterface::class)->relatedPosts($post, $limit);
    }
}

if (!function_exists('get_cms_page_setting_view')) {
    function get_cms_page_setting_view($item)
    {
        if ($item && $item->page_layout) {
            $setting_view = 'admin.pages.'.$item->page_layout;

            return view()->exists($setting_view) ? $setting_view : null;
        }

        return null;
    }
}

if (!function_exists('get_cms_page_url')) {
    function get_cms_page_url($page_id)
    {
        $page = Page::find($page_id);
        return $page?->url;
    }
}
