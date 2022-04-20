<?php

namespace App\Http\Controllers\Api\Leagues;

use App\Enums\SportIdEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leagues\LeagueResource;
use App\Services\LeagueService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/leagues",
 *     summary="Get Leagues",
 *     tags={"Leagues"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/LeagueResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Leagues extends Controller
{
    public function __invoke(LeagueService $leagueService): AnonymousResourceCollection
    {
        $leagues = $leagueService->getListBySportId(SportIdEnum::soccer);

        return LeagueResource::collection($leagues);
    }
}
