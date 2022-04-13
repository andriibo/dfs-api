<?php

namespace App\Models;

use App\Enums\FileUploads\IsApprovedEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FileUpload.
 *
 * @property int    $id
 * @property string $session_id
 * @property string $secret
 * @property int    $file_type
 * @property string $file_path_tmp
 * @property string $file_path
 * @property string $file_name
 * @property string $file_extention
 * @property string $file_realname
 * @property string $image_dimensions
 * @property string $image_crop
 * @property string $image_crop_ratio
 * @property string $video_snapshot_name
 * @property int    $media_duration
 * @property string $upload_date
 * @property int    $is_approved
 * @property string $date_updated
 *
 * @method static Builder|FileUpload newModelQuery()
 * @method static Builder|FileUpload newQuery()
 * @method static Builder|FileUpload query()
 * @method static Builder|FileUpload whereDateUpdated($value)
 * @method static Builder|FileUpload whereFileExtention($value)
 * @method static Builder|FileUpload whereFileName($value)
 * @method static Builder|FileUpload whereFilePath($value)
 * @method static Builder|FileUpload whereFilePathTmp($value)
 * @method static Builder|FileUpload whereFileRealname($value)
 * @method static Builder|FileUpload whereFileType($value)
 * @method static Builder|FileUpload whereId($value)
 * @method static Builder|FileUpload whereImageCrop($value)
 * @method static Builder|FileUpload whereImageCropRatio($value)
 * @method static Builder|FileUpload whereImageDimensions($value)
 * @method static Builder|FileUpload whereIsApproved($value)
 * @method static Builder|FileUpload whereMediaDuration($value)
 * @method static Builder|FileUpload whereSecret($value)
 * @method static Builder|FileUpload whereSessionId($value)
 * @method static Builder|FileUpload whereUploadDate($value)
 * @method static Builder|FileUpload whereVideoSnapshotName($value)
 * @mixin Eloquent
 */
class FileUpload extends Model
{
    public $timestamps = false;

    protected $table = 'file_uploads';

    protected $fillable = [
        'session_id',
        'secret',
        'file_type',
        'file_path_tmp',
        'file_path',
        'file_name',
        'file_extention',
        'file_realname',
        'image_dimensions',
        'image_crop',
        'image_crop_ratio',
        'video_snapshot_name',
        'media_duration',
        'upload_date',
        'is_approved',
        'date_updated',
    ];

    public function getFileUrl(): string
    {
        return ($this->is_approved == IsApprovedEnum::yes->value)
            ? "{$this->file_path}{$this->file_name}.{$this->file_extention}"
            : "{$this->file_path_tmp}{$this->file_name}.{$this->file_extention}";
    }
}
