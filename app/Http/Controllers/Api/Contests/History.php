<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contests\ContestResource;
use App\Services\ContestService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/history",
 *     summary="Get Contests History",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class History extends Controller
{
    public function __invoke(ContestService $contestService): AnonymousResourceCollection
    {
        $contests = $contestService->getContestsHistory(auth()->user()->id);

        return ContestResource::collection($contests);
    }
}
