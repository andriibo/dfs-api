<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contests\ContestResource;
use App\Services\ContestService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Get(
 *     path="/contests/upcoming",
 *     summary="Get Contests Upcoming",
 *     tags={"Contests"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/vnd.api+json")
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *            @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Not Found",
 *         @OA\JsonContent(
 *            @OA\Property(property="error", type="string", example="Resource not found.")
 *         )
 *     ),
 *     @OA\Response(response=405, description="Method Not Allowed",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The current method is not supported for this route. Supported methods: GET.")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class Upcoming extends Controller
{
    public function __invoke(ContestService $contestService): AnonymousResourceCollection
    {
        $contests = Auth::check() ? $contestService->getContestsUpcoming(auth()->user()->id) : [];

        return ContestResource::collection($contests);
    }
}
