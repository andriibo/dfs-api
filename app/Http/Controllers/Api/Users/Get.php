<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     summary="Get User",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *
 *     @OA\Parameter(name="id", in="path"),
 *
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="int", example="1"),
 *             @OA\Property(property="username", type="string", example="username")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             oneOf={
 *                @OA\Property(property="msg", type="string"),
 *                @OA\Property(property="error", type="string")
 *             }
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class Get extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        return response()->json([
            'id' => 1,
            'username' => 'test',
        ]);
    }
}
