<?php

namespace App\Http\Controllers\Api\Contests;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceQuery\GetCollectionQuery;
use App\Http\Resources\Contests\ContestResource;
use App\Repositories\ContestRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Get(
 *     path="/contests/history",
 *     summary="Get Contests History",
 *     tags={"Contests"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/accept"),
 *     @OA\Parameter(ref="#/components/parameters/сontentType"),
 *     @OA\Parameter(ref="#/components/parameters/page"),
 *     @OA\Parameter(name="sort", in="query", style="deepObject", explode=true, @OA\Schema(type="string", enum={"title","-title","salaryCap","-salaryCap","entries","-entries","entryFee","-entryFee","prizeBank","-prizeBank","startDate","-startDate"})),
 *     @OA\Parameter(name="filter", in="query", style="deepObject", explode=true,
 *       @OA\Schema(
 *         @OA\Property(property="sportId", type="integer", enum={1,2,3}, description="1 - Soccer, 2- Football, 3 - Cricket"),
 *         @OA\Property(property="contestType", type="string", enum={"fifty-fifty","head-to-head","multiplier","wta","top-three","custom"}),
 *         @OA\Property(property="leagueId", type="integer", example="54"),
 *         @OA\Property(property="entryFee", type="string", example="50-100"),
 *       )
 *     ),
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
class History extends Controller
{
    public function __invoke(
        GetCollectionQuery $getCollectionQuery,
        ContestRepository $contestRepository,
    ): ResourceCollection {
        $contests = $contestRepository->getContestsHistory(auth()->user()->id);

        return ContestResource::collection($contests);
    }
}
