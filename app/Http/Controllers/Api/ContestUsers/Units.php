<?php

namespace App\Http\Controllers\Api\ContestUsers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContestUsers\UnitsResource;
use App\Repositories\ContestUserRepository;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Get(
 *     path="/contest-users/{entryId}/units",
 *     summary="Get Lineup",
 *     tags={"Contest Users"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(name="entryId", required=true, in="path", @OA\Schema(type="integer", example="33")),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/UnitsResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Units extends Controller
{
    public function __invoke(
        int $entryId,
        ContestUserRepository $contestUserRepository
    ): JsonResource {
        $entryContestUser = $contestUserRepository->getById($entryId);

        return new UnitsResource($entryContestUser);
    }
}
