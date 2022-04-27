<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Collections\ContestCollection;
use App\Http\Controllers\Controller;
use App\Repositories\ContestRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/live",
 *     summary="Get Contests Live",
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
class Live extends Controller
{
    public function __invoke(ContestRepository $contestRepository): ResourceCollection
    {
        $contests = $contestRepository->getContestsLive(auth()->user()->id);

        return new ContestCollection($contests);
    }
}
