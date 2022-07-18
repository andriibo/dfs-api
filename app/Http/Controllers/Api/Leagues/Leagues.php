<?php

namespace App\Http\Controllers\Api\Leagues;

use App\Http\Controllers\Controller;
use App\Http\Resources\Leagues\LeagueResource;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/leagues",
 *     summary="Get Leagues",
 *     tags={"Leagues"},
 *     @OA\Parameter(ref="#/components/parameters/accept"),
 *     @OA\Parameter(ref="#/components/parameters/сontentType"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/LeagueResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Leagues extends Controller
{
    public function __invoke(LeagueRepository $leagueRepository): AnonymousResourceCollection
    {
        $leagues = $leagueRepository->getLeagues();

        return LeagueResource::collection($leagues);
    }
}
