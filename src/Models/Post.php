<?php

namespace Newnet\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Newnet\Seo\Traits\SeoableTrait;
use Newnet\Core\Support\Traits\TranslatableTrait;
use Newnet\Media\Traits\HasMediaTrait;
use Newnet\Tag\Traits\TaggableTrait;

/**
 * Newnet\Cms\Models\Post
 *
 * @property int $id
 * @property array|null $name
 * @property string|null $slug
 * @property string|null $post_type
 * @property array|null $description
 * @property array|null $content
 * @property bool $is_active
 * @property bool $is_sticky
 * @property int|null $sort_order
 * @property string|null $author_type
 * @property int|null $author_id
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int|null $is_viewed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $author
 * @property \Kalnoy\Nestedset\Collection<int, \Newnet\Cms\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property mixed $image
 * @property mixed $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Newnet\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property \Newnet\Seo\Models\Meta|null $seometa
 * @property \Newnet\Seo\Models\Url|null $seourl
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Newnet\Seo\Models\Url> $seourls
 * @property-read int|null $seourls_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Newnet\Tag\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsSticky($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withAllTags($tags, ?string $group = null, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withAnyTags($tags, ?string $group = null, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutAnyTags()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTags($tags, ?string $group = null, ?string $locale = null)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasMediaTrait;
    use TaggableTrait;
    use SeoableTrait;
    use TranslatableTrait;

    protected $table = 'cms__posts';

    protected $fillable = [
        'name',
        'post_type',
        'description',
        'content',
        'is_active',
        'is_sticky',
        'sort_order',
        'published_at',
        'categories',
        'image',
        'is_viewed',
        'author_type',
        'author_id',
    ];

    public $translatable = [
        'name',
        'description',
        'content',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_sticky' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['published_at'] = now();

        parent::__construct($attributes);
    }

    public function author()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cms__post_category');
    }

    public function getUrl()
    {
        return route('cms.web.post.detail', $this->id);
    }

    public function getCategoryAttribute()
    {
        return $this->categories->first();
    }

    public function setCategoriesAttribute($value)
    {
        $value = array_filter($value);
        static::saved(function ($model) use ($value) {
            $model->categories()->sync($value);
        });
    }

    public function setImageAttribute($value)
    {
        $this->mediaAttributes['image'] = $value;
    }

    public function getImageAttribute()
    {
        return $this->getFirstMedia('image');
    }

    public function getDescAttribute()
    {
        return $this->description ?: Str::limit(strip_tags($this->content), 200);
    }
}
