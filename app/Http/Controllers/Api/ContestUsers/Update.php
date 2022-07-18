<?php

namespace App\Http\Controllers\Api\ContestUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContestUsers\UpdateContestUserRequest;
use App\Http\Resources\ContestUsers\ContestUserDetailsResource;
use App\Repositories\ContestUserRepository;
use App\Services\ContestUserUnits\CreateContestUserUnitsService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * @OA\Put(
 *     path="/contest-users/{id}",
 *     summary="Update Contest User",
 *     tags={"Contest Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/accept"),
 *     @OA\Parameter(ref="#/components/parameters/сontentType"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(ref="#/components/requestBodies/UpdateContestUserRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", ref="#/components/schemas/ContestUserDetailsResource")
 *         )
 *     ),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Update extends Controller
{
    public function __invoke(
        int $contestUserId,
        UpdateContestUserRequest $updateContestUserRequest,
        ContestUserRepository $contestUserRepository,
        CreateContestUserUnitsService $createContestUserUnitsService
    ): JsonResource {
        $contestUser = $contestUserRepository->getById($contestUserId);
        $createContestUserUnitsService->handle($contestUser, $updateContestUserRequest->input('units', []));

        return new ContestUserDetailsResource($contestUser);
    }
}
