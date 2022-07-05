<?php

namespace App\Http\Controllers\Api\Sockets;

use App\Events\UserTransactionCreatedEvent;
use App\Http\Controllers\Controller;
use App\Repositories\UserTransactionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/sockets/user-transactions/{id}",
 *     summary="Room `users/{id}/transaction`",
 *     tags={"Sockets"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response=201, ref="#/components/responses/201"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class UserTransaction extends Controller
{
    public function __invoke(
        int $userTransactionId,
        UserTransactionRepository $userTransactionRepository
    ): JsonResponse {
        $userTransaction = $userTransactionRepository->getById($userTransactionId);
        if ($userTransaction->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'You are not allowed to handle this action.'], Response::HTTP_FORBIDDEN);
        }
        event(new UserTransactionCreatedEvent($userTransaction));

        return response()->json([], Response::HTTP_CREATED);
    }
}
