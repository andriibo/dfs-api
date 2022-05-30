<?php

namespace App\Services\Users;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateAvatarService
{
    public function handle(Authenticatable $user, UploadedFile $file): bool
    {
        $storage = Storage::disk('s3');
        if ($user->avatar && $storage->exists($user->avatar)) {
            $storage->delete($user->avatar);
        }

        $name = time() . $file->getClientOriginalName();
        $filePath = 'users/' . $name;
        if ($storage->put($filePath, file_get_contents($file))) {
            $user->avatar = $filePath;

            return $user->save();
        }

        return false;
    }
}
