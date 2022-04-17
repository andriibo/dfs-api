<?php

namespace App\Http\Controllers\Api\Leagues;

use App\Enums\SportIdEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leagues\LeaguesResource;
use App\Services\LeagueService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/leagues",
 *     summary="Get Leagues",
 *     tags={"Leagues"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/vnd.api+json")
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/LeaguesResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class Leagues extends Controller
{
    public function __invoke(LeagueService $leagueService): AnonymousResourceCollection
    {
        $leagues = $leagueService->getListBySportId(SportIdEnum::soccer);

        return LeaguesResource::collection($leagues);
    }
}
