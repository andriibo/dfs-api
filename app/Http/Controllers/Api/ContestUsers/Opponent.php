<?php

namespace App\Http\Controllers\Api\ContestUsers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContestUsers\ContestUserDetailsResource;
use App\Repositories\ContestUserRepository;
use App\Specifications\CanSeeOpponentUnitsSpecification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/contest-users/{entryId}/opponent/{opponentId}",
 *     summary="Get Opponent Contest Unser",
 *     tags={"Contest Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(name="entryId", required=true, in="path", @OA\Schema(type="integer", example="11")),
 *     @OA\Parameter(name="opponentId", required=true, in="path", @OA\Schema(type="integer", example="23")),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/ContestUserDetailsResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Opponent extends Controller
{
    public function __invoke(
        int $entryId,
        int $opponentId,
        ContestUserRepository $contestUserRepository,
        CanSeeOpponentUnitsSpecification $canSeeOpponentLineupSpecification
    ): JsonResource|JsonResponse {
        $entryContestUser = $contestUserRepository->getById($entryId);
        $opponentContestUser = $contestUserRepository->getById($opponentId);

        if (!$canSeeOpponentLineupSpecification->isSatisfiedBy($entryContestUser, $opponentContestUser)) {
            return response()->json(['message' => "You are not allowed to see opponent's lineup"], Response::HTTP_FORBIDDEN);
        }

        return new ContestUserDetailsResource($opponentContestUser);
    }
}
