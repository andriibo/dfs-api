<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserAvatarRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Post(
 *     path="/users/avatar",
 *     summary="Update User Avatar",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(name="Content-Type", in="header", description="Content-Type header", @OA\Schema(type="string", example="multipart/form-data")),
 *     @OA\RequestBody(ref="#/components/requestBodies/UpdateUserAvatarRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Image uploaded successfully!")
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Avatar extends Controller
{
    public function __invoke(UpdateUserAvatarRequest $updateUserAvatarRequest): JsonResponse
    {
        $file = $updateUserAvatarRequest->file('image');
        $name = time() . $file->getClientOriginalName();
        $filePath = 'images/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return response()->json(['message' => 'Image uploaded successfully!']);
    }
}
