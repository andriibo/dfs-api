<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/auth/logout",
 *     summary="Logout",
 *     tags={"Auth"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="message", type="string", example="Successfully logged out")
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Logout extends Controller
{
    public function __invoke(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
        ]);
    }
}
