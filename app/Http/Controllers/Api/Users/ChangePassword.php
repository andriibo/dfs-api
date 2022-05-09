<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Patch(
 *     path="/users/password",
 *     summary="Change User Password",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(ref="#/components/requestBodies/ChangePasswordRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Password successfully changed!")
 *         )
 *     ),
 *     @OA\Response(response=400, ref="#/components/responses/400"),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class ChangePassword extends Controller
{
    public function __invoke(ChangePasswordRequest $changePasswordRequest): JsonResponse
    {
        $user = Auth::user();

        if (!Hash::check($changePasswordRequest->currentPassword, $user->password)) {
            return response()->json(['message' => 'Current password does not match!'], Response::HTTP_BAD_REQUEST);
        }

        $user->password = Hash::make($changePasswordRequest->password);
        $user->save();

        return response()->json(['message' => 'Password successfully changed!']);
    }
}
