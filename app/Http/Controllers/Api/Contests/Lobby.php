<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contests\ContestResource;
use App\Services\ContestService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/lobby",
 *     summary="Get Contests Lobby",
 *     tags={"Contests"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Lobby extends Controller
{
    public function __invoke(ContestService $contestService): AnonymousResourceCollection
    {
        $contests = $contestService->getContestsLobby();

        return ContestResource::collection($contests);
    }
}
