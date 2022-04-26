<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Collections\ContestCollection;
use App\Http\Controllers\Controller;
use App\Services\Contests\ContestUpcomingService;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/upcoming",
 *     summary="Get Contests Upcoming",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/page"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(ref="#/components/schemas/ContestCollection")
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Upcoming extends Controller
{
    public function __invoke(ContestUpcomingService $contestUpcomingService): ResourceCollection
    {
        $contests = $contestUpcomingService->handle(auth()->user()->id);

        return new ContestCollection($contests);
    }
}
