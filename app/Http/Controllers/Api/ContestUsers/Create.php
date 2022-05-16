<?php

namespace App\Http\Controllers\Api\ContestUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContestUsers\CreateContestUserRequest;
use App\Http\Resources\ContestUsers\ContestUserResource;
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
 *     path="/contest-users",
 *     summary="Create Contest User",
 *     tags={"Contest Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(ref="#/components/requestBodies/CreateContestUserRequest"),
 *     @OA\Response(response=201, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestUserResource")
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
class Create extends Controller
{
    public function __invoke(
        CreateContestUserRequest $createContestUserRequest,
        ContestRepository $contestRepository,
        ContestCanBeEnteredSpecification $contestCanBeEnteredSpecification,
        UserReachedContestEntryLimitSpecification $userReachedContestEntryLimitSpecification,
        UserCanPaySpecification $userCanPaySpecification,
        EnterContestService $enterContestService
    ): JsonResponse|JsonResource {
        $contest = $contestRepository->getContestById($createContestUserRequest->input('contestId'));
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

        $contestUser = $enterContestService->handle($contest, $user->id, $createContestUserRequest->input('units', []));

        return new ContestUserResource($contestUser);
    }
}
