<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Services\Transactions\CreateDailyBonusDepositService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/transactions/daily-bonus",
 *     summary="Get Daily Bonus",
 *     tags={"Transactions"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You have successfully received daily bonus!")
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class DailyBonus extends Controller
{
    public function __invoke(CreateDailyBonusDepositService $createDailyBonusDepositService, UserService $userService): JsonResponse
    {
        $user = auth()->user();
        $userTransaction = $createDailyBonusDepositService->handle($user->id);

        if (!$userTransaction) {
            return response()->json(['message' => 'You have already received the daily bonus today!'], Response::HTTP_FORBIDDEN);
        }

        $userService->updateBalance($user, $userTransaction->amount);

        return response()->json(['message' => 'You have successfully received daily bonus!']);
    }
}
