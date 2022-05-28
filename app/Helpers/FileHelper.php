<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function getPublicUrl(?string $fileName): ?string
    {
        if (is_null($fileName)) {
            return null;
        }

        return Storage::disk('s3')->url($fileName);
    }
}
