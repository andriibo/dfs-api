<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserProfileRequest;
use App\Http\Resources\Users\ProfileResource;
use App\Services\Users\UpdateProfileService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Put(
 *     path="/users/profile",
 *     summary="Update User Profile",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(ref="#/components/requestBodies/UpdateUserProfileRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ProfileResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Update extends Controller
{
    public function __invoke(
        UpdateUserProfileRequest $updateUserProfileRequest,
        UpdateProfileService $updateProfileService
    ): JsonResponse {
        $user = auth()->user();
        $updateProfileService->handle($user, $updateUserProfileRequest->validated());

        return response()->json(['data' => new ProfileResource($user)]);
    }
}
