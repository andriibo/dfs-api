<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailTemplate.
 *
 * @property int      $id
 * @property string   $name
 * @property string   $title
 * @property string   $placeholders
 * @property string   $subject_en
 * @property string   $body_en
 * @property string   $comment
 * @property string   $date_updated
 * @property null|int $in_system
 *
 * @method static Builder|EmailTemplate newModelQuery()
 * @method static Builder|EmailTemplate newQuery()
 * @method static Builder|EmailTemplate query()
 * @method static Builder|EmailTemplate whereBodyEn($value)
 * @method static Builder|EmailTemplate whereComment($value)
 * @method static Builder|EmailTemplate whereDateUpdated($value)
 * @method static Builder|EmailTemplate whereId($value)
 * @method static Builder|EmailTemplate whereInSystem($value)
 * @method static Builder|EmailTemplate whereName($value)
 * @method static Builder|EmailTemplate wherePlaceholders($value)
 * @method static Builder|EmailTemplate whereSubjectEn($value)
 * @method static Builder|EmailTemplate whereTitle($value)
 * @mixin Eloquent
 */
class EmailTemplate extends Model
{
    public $timestamps = false;

    protected $table = 'email_templates';

    protected $fillable = [
        'name',
        'title',
        'placeholders',
        'subject_en',
        'body_en',
        'comment',
        'date_updated',
        'in_system',
    ];
}
