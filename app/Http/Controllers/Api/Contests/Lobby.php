<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contests\ContestsLobbyResource;
use App\Services\ContestService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/lobby",
 *     summary="Get Contests Lobby",
 *     tags={"Contests"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/json")
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestsLobbyResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *            @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class Lobby extends Controller
{
    public function __invoke(ContestService $contestService): AnonymousResourceCollection
    {
        $contests = $contestService->getContestsLobby();

        return ContestsLobbyResource::collection($contests);
    }
}
