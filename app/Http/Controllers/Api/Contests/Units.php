<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contests\UnitsRequest;
use App\Http\Resources\Contests\ContestResource;
use App\Repositories\ContestRepository;
use App\Services\Contests\EnterContestService;
use App\Specifications\ContestCanBeEnteredSpecification;
use App\Specifications\UserCanPaySpecification;
use App\Specifications\UserReachedContestEntryLimitSpecification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/contests/{id}/units",
 *     summary="Create Contest Units",
 *     tags={"Contests"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(ref="#/components/requestBodies/UnitsRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Units extends Controller
{
    public function __invoke(
        int $contestId,
        UnitsRequest $unitsRequest,
        ContestRepository $contestRepository,
        ContestCanBeEnteredSpecification $contestCanBeEnteredSpecification,
        UserReachedContestEntryLimitSpecification $userReachedContestEntryLimitSpecification,
        UserCanPaySpecification $userCanPaySpecification,
        EnterContestService $enterContestService
    ): JsonResponse|JsonResource {
        $contest = $contestRepository->getContestById($contestId);
        $user = auth()->user();

        if (!$contestCanBeEnteredSpecification->isSatisfiedBy($contest)) {
            return response()->json(['message' => 'This contest can not be entered.'], Response::HTTP_FORBIDDEN);
        }

        if (!$userReachedContestEntryLimitSpecification->isSatisfiedBy($contest, $user->id)) {
            return response()->json(['message' => 'You have reached contest entry limit.'], Response::HTTP_FORBIDDEN);
        }

        if (!$userCanPaySpecification->isSatisfiedBy($user, $contest->entry_fee)) {
            return response()->json(['message' => 'Not enough funds to pay entry fee.'], Response::HTTP_FORBIDDEN);
        }

        $enterContestService->handle($contest, $user->id, $unitsRequest->input('units', []));

        return new ContestResource($contest);
    }
}
