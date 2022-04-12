<?php

namespace App\Http\Controllers\Api\Leagues;

use App\Enums\SportIdEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leagues\GetLeaguesResource;
use App\Services\LeagueService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/leagues",
 *     summary="Get Leagues",
 *     tags={"Leagues"},
 *     security={ {"bearerAuth" : {} }},
 *
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/GetLeaguesResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             oneOf={
 *                @OA\Property(property="msg", type="string"),
 *                @OA\Property(property="error", type="string")
 *             }
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class LeaguesGet extends Controller
{
    public function __invoke(LeagueService $leagueService): AnonymousResourceCollection
    {
        $leagues = $leagueService->getListBySportId(SportIdEnum::soccer);

        return GetLeaguesResource::collection($leagues);
    }
}