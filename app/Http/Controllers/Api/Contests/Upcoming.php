<?php

namespace App\Http\Controllers\Api\Contests;

use App\Filters\ContestQueryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceQuery\GetCollectionQuery;
use App\Http\Resources\Contests\ContestResource;
use App\Repositories\ContestRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/upcoming",
 *     summary="Get Contests Upcoming",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/accept"),
 *     @OA\Parameter(ref="#/components/parameters/сontentType"),
 *     @OA\Parameter(ref="#/components/parameters/page"),
 *     @OA\Parameter(ref="#/components/parameters/contestSort"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ContestResource")),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationSchemaOA/properties/links"),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationSchemaOA/properties/meta")
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Upcoming extends Controller
{
    public function __invoke(
        GetCollectionQuery $getCollectionQuery,
        ContestQueryFilter $contestQueryFilter,
        ContestRepository $contestRepository
    ): ResourceCollection {
        $contests = $contestRepository->getContestsUpcoming(auth()->user()->id, $contestQueryFilter);

        return ContestResource::collection($contests);
    }
}
