<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Collections\ContestCollection;
use App\Http\Controllers\Controller;
use App\Services\ContestService;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/lobby",
 *     summary="Get Contests Lobby",
 *     tags={"Contests"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/page[number]"),
 *     @OA\Parameter(ref="#/components/parameters/page[size]"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(ref="#/components/schemas/ContestCollection")
 *     ),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Lobby extends Controller
{
    public function __invoke(ContestService $contestService): ResourceCollection
    {
        $contests = $contestService->getContestsLobby();

        return new ContestCollection($contests);
    }
}
