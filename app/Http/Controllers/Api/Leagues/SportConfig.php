<?php

namespace App\Http\Controllers\Api\Leagues;

use App\Factories\SportConfigFactory;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leagues\SportConfigResource;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Get(
 *     path="/leagues/{id}/sport-config",
 *     summary="Get Sport Config",
 *     tags={"Leagues"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/SportConfigResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class SportConfig extends Controller
{
    public function __invoke(int $leagueId, LeagueRepository $leagueRepository): JsonResource
    {
        $league = $leagueRepository->getLeagueById($leagueId);

        $sportConfig = SportConfigFactory::getConfig($league->sport_id);

        return new SportConfigResource($sportConfig);
    }
}
