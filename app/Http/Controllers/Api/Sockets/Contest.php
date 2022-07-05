<?php

namespace App\Http\Controllers\Api\Sockets;

use App\Events\ContestUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Repositories\ContestRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/sockets/contests/{id}",
 *     summary="Room `contests`",
 *     tags={"Sockets"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response=201, ref="#/components/responses/201"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Contest extends Controller
{
    public function __invoke(
        int $contestId,
        ContestRepository $contestRepository
    ): JsonResponse {
        $contest = $contestRepository->getContestById($contestId);
        event(new ContestUpdatedEvent($contest));

        return response()->json([], Response::HTTP_CREATED);
    }
}
