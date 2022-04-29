<?php

namespace App\Models\Soccer;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoccerPlayer extends Model
{
    protected $table = 'player';

    protected $fillable = [
        'feed_type',
        'feed_id',
        'sport_id',
        'first_name',
        'last_name',
        'photo_id',
        'injury_status',
        'salary',
        'auto_salary',
        'total_fantasy_points',
        'total_fantasy_points_per_game',
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class);
    }

    public function getPhoto(): string
    {
        return $this->photo
            ? $this->photo->file_name . '.' . $this->photo->file_extention
            : '';
    }

    public function getFullName(): string
    {
        $name = array_filter([
            $this->first_name,
            $this->last_name,
        ]);

        return implode(' ', $name);
    }
}
