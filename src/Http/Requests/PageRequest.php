<?php

namespace Newnet\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Newnet\Cms\Models\Page;
use Newnet\Seo\Models\Url;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * The "home" layout must always live at "/" - typing (or leaving) any
     * other slug here is always a mistake, since the frontend only ever
     * renders the home layout for the "/" request path. Force it here,
     * server-side, so it can't be bypassed by editing the form/request.
     */
    protected function prepareForValidation()
    {
        if ($this->input('page_layout') === 'home') {
            $this->merge([
                'seourl' => array_merge((array) $this->input('seourl', []), [
                    'request_path' => '/',
                ]),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pageId = $this->route('page');

        return [
            'name' => 'required',
            // 'slug' => 'required|unique:cms__pages,slug,'.$id,
            'seourl.request_path' => [
                function ($attribute, $value, $fail) use ($pageId) {
                    if ($value !== '/') {
                        return;
                    }

                    $taken = Url::query()
                        ->where('urlable_type', Page::class)
                        ->where('locale', get_current_edit_locale())
                        ->where('request_path', '/')
                        ->when($pageId, fn ($query) => $query->where('urlable_id', '!=', $pageId))
                        ->exists();

                    if ($taken) {
                        $fail(__('cms::page.validation.home_url_taken'));
                    }
                },
            ],
        ];
    }


    public function attributes()
    {
        return [
            'name' => __('cms::page.name'),
            'slug' => __('cms::page.slug'),
            'seourl.request_path' => __('seo::meta.url'),
        ];
    }
}
