<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\StaticPageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\StaticPage.
 *
 * @property int    $id
 * @property string $name
 * @property string $title_en
 * @property string $content_en
 * @property string $description_en
 * @property string $keywords_en
 * @property string $link_text_en
 * @property int    $enabled
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static StaticPageFactory factory(...$parameters)
 * @method static Builder|StaticPage newModelQuery()
 * @method static Builder|StaticPage newQuery()
 * @method static Builder|StaticPage query()
 * @method static Builder|StaticPage whereContentEn($value)
 * @method static Builder|StaticPage whereCreatedAt($value)
 * @method static Builder|StaticPage whereDescriptionEn($value)
 * @method static Builder|StaticPage whereEnabled($value)
 * @method static Builder|StaticPage whereId($value)
 * @method static Builder|StaticPage whereKeywordsEn($value)
 * @method static Builder|StaticPage whereLinkTextEn($value)
 * @method static Builder|StaticPage whereName($value)
 * @method static Builder|StaticPage whereTitleEn($value)
 * @method static Builder|StaticPage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StaticPage extends Model
{
    use HasFactory;

    protected $table = 'static_pages';

    protected $fillable = [
        'name',
        'title_en',
        'content_en',
        'description_en',
        'keywords_en',
        'link_text_en',
        'enabled',
    ];
}
