<?php

namespace App\Http\Controllers\Api\Sockets;

use App\Events\UserBalanceUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Repositories\ContestRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/sockets/users/{id}/balance",
 *     summary="Room `users/{id}/balance`",
 *     tags={"Sockets"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/accept"),
 *     @OA\Parameter(ref="#/components/parameters/сontentType"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response=201, ref="#/components/responses/201"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class UserBalance extends Controller
{
    public function __invoke(
        int $contestId,
        ContestRepository $contestRepository
    ): JsonResponse {
        event(new UserBalanceUpdatedEvent(auth()->user()));

        return response()->json([], Response::HTTP_CREATED);
    }
}
