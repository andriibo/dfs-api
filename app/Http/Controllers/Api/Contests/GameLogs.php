<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Collections\GameLogCollection;
use App\Http\Controllers\Controller;
use App\Repositories\ContestRepository;
use App\Services\GameLogService;
use App\Specifications\UserInContestSpecification;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
 *         @OA\JsonContent(ref="#/components/schemas/GameLogCollection")
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
    ): GameLogCollection|JsonResponse {
        $userId = auth()->user()->id;
        if (!$userInContestSpecification->isSatisfiedBy($contestId, $userId)) {
            return response()->json(['message' => 'You are not in contest'], Response::HTTP_FORBIDDEN);
        }

        $contest = $contestRepository->getContestById($contestId);
        $gameLogs = $gameLogService->getGameLogs($contest);

        return new GameLogCollection($gameLogs);
    }
}
