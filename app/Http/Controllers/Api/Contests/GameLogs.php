<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameLogs\GameLogResource;
use App\Repositories\ContestRepository;
use App\Services\GameLogService;
use App\Specifications\UserInContestSpecification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/contests/{id}/game-logs",
 *     summary="Get Contest Game Logs",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Parameter(ref="#/components/parameters/page"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/GameLogResource")),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationSchemaOA/properties/links"),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationSchemaOA/properties/meta")
 *         )
 *     ),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class GameLogs extends Controller
{
    public function __invoke(
        int $contestId,
        GameLogService $gameLogService,
        ContestRepository $contestRepository,
        UserInContestSpecification $userInContestSpecification
    ): AnonymousResourceCollection|JsonResponse {
        $userId = auth()->user()->id;
        if (!$userInContestSpecification->isSatisfiedBy($contestId, $userId)) {
            return response()->json(['message' => 'You are not in contest'], Response::HTTP_FORBIDDEN);
        }

        $contest = $contestRepository->getContestById($contestId);
        $gameLogs = $gameLogService->getGameLogs($contest);

        return GameLogResource::collection($gameLogs);
    }
}
