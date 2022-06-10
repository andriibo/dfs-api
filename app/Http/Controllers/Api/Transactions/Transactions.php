<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceQuery\GetCollectionQuery;
use App\Http\Resources\Transactions\TransactionResource;
use App\Repositories\UserTransactionRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/transactions",
 *     summary="Get User Transactions",
 *     tags={"Transactions"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(ref="#/components/parameters/page"),
 *     @OA\Parameter(name="filter", in="query", style="deepObject", explode=true,
 *        @OA\Schema(
 *          @OA\Property(property="type", type="integer", example="4"),
 *          @OA\Property(property="date_start", type="string", example="2022-02-24"),
 *          @OA\Property(property="date_end", type="string", example="2022-02-27")
 *        )
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TransactionResource")),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationSchemaOA/properties/links"),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationSchemaOA/properties/meta")
 *         )
 *     ),
 *     @OA\Response(response=400, ref="#/components/responses/400"),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Transactions extends Controller
{
    public function __invoke(GetCollectionQuery $getCollectionQuery, UserTransactionRepository $userTransactionRepository): AnonymousResourceCollection
    {
        $userTransactions = $userTransactionRepository->getTransactionsByUserId(auth()->user()->id);

        return TransactionResource::collection($userTransactions);
    }
}
