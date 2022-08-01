<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserAvatarRequest;
use App\Services\Users\UpdateAvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Post(
 *     path="/users/avatar",
 *     summary="Update User Avatar",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(name="Content-Type", in="header", description="Content-Type header", @OA\Schema(type="string", example="multipart/form-data")),
 *     @OA\RequestBody(ref="#/components/requestBodies/UpdateUserAvatarRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Image uploaded successfully!")
 *         )
 *     ),
 *     @OA\Response(response=400, ref="#/components/responses/400"),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Avatar extends Controller
{
    public function __invoke(
        UpdateUserAvatarRequest $updateUserAvatarRequest,
        UpdateAvatarService $updateAvatarService
    ): JsonResponse {
        $user = auth()->user();
        $file = $updateUserAvatarRequest->file('image');

        if (!$updateAvatarService->handle($user, $file)) {
            return response()->json(['message' => 'Bad request.'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'Image uploaded successfully!']);
    }
}
