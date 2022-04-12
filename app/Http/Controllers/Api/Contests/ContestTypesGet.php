<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contests\GetContestTypesResource;
use App\Services\ContestService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/types",
 *     summary="Get Contest Types",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/GetContestTypesResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             oneOf={
 *                @OA\Property(property="msg", type="string"),
 *                @OA\Property(property="error", type="string")
 *             }
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *            type="object",
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class ContestTypesGet extends Controller
{
    public function __invoke(ContestService $contestService): AnonymousResourceCollection
    {
        $types = $contestService->getContestTypes();

        return GetContestTypesResource::collection($types);
    }
}
