@translatableAlert

<ul class="nav nav-tabs scrollable">
    <li class="nav-item">
        <a class="nav-link active save-tab" data-toggle="pill" href="#cmsPostInfo">
            {{ __('cms::post.tabs.info') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link save-tab" data-toggle="pill" href="#cmsPostSeo">
            {{ __('cms::post.tabs.seo') }}
        </a>
    </li>
</ul>

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="cmsPostInfo">
        <div class="row">
            <div class="col-12 col-md-9">
                @input(['name' => 'name', 'label' => __('cms::post.name')])
                @textarea(['name' => 'description', 'label' => __('cms::post.description'), 'autoResize' => true])
                @editor(['name' => 'content', 'label' => __('cms::post.content')])
            </div>
            <div class="col-12 col-md-3">
                @translatable

                @checkbox(['name' => 'is_active', 'label' => __('cms::post.is_active'), 'default' => true])
                @checkbox(['name' => 'is_sticky', 'label' => __('cms::post.is_sticky')])
                @input(['name' => 'sort_order', 'label' => __('cms::post.sort_order')])

                <div class="allway-open-sumoselect">
                    @sumoselect(['name' => 'categories', 'label' => __('cms::post.category'), 'multiple' => true, 'options' => get_category_parent_options()])
                </div>
                @if(config('cms.cms.media_manager') && config('cms.cms.media_manager') == true)
                    @mediamanager(['name' => 'image', 'label' => __('cms::post.image')])
                @else
                    @mediafile(['name' => 'image', 'label' => __('cms::post.image')])
                @endif
                @tags
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="cmsPostSeo">
        @seo
    </div>
</div>
