<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContestUnits\ContestUnitResource;
use App\Repositories\ContestUnitRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/{id}/players",
 *     summary="Get Contest Players",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestUnitResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Players extends Controller
{
    public function __invoke(int $contestId, ContestUnitRepository $contestUnitRepository): AnonymousResourceCollection
    {
        $contestUnits = $contestUnitRepository->getContestUnitsByContestId($contestId);

        return ContestUnitResource::collection($contestUnits);
    }
}
