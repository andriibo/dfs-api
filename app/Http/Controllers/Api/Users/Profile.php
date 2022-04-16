<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\ProfileResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/users/profile",
 *     summary="Get User Profile",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/json")
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ProfileResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unauthorized")
 *         )
 *     ),
 *     @OA\Response(response=403, description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Forbidden")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Resource not found")
 *         )
 *     ),
 *     @OA\Response(response=422, description="Unprocessable entity",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unprocessable entity")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Internal Server Error")
 *         )
 *     )
 * )
 */
class Profile extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new ProfileResource(auth()->user()),
        ]);
    }
}
