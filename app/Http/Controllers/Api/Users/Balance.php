<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/users/balance",
 *     summary="Get User Balance",
 *     tags={"Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/vnd.api+json")
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data",
 *                 @OA\Property(property="balance", type="number", format="double", example="100.23")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(response=403, description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Forbidden")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Resource not found.")
 *         )
 *     ),
 *     @OA\Response(response=405, description="Method Not Allowed",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The current method is not supported for this route. Supported methods: GET.")
 *         )
 *     ),
 *     @OA\Response(response=422, description="Unprocessable entity",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Server Error")
 *         )
 *     )
 * )
 */
class Balance extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['data' => ['balance' => auth()->user()->balance]]);
    }
}
