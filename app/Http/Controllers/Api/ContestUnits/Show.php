<?php

namespace App\Http\Controllers\Api\ContestUnits;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contests\ContestDetailsResource;
use App\Repositories\ContestUnitRepository;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Get(
 *     path="/contest-units/{id}",
 *     summary="Get Contest Unit",
 *     tags={"Contest Units"},
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
class Show extends Controller
{
    public function __invoke(int $contestUnitId, ContestUnitRepository $contestUnitRepository): JsonResource
    {
        $contestUnit = $contestUnitRepository->getContestUnitById($contestUnitId);

        return new ContestDetailsResource($contestUnit);
    }
}
