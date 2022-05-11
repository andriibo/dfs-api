<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transactions\TransactionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Get(
 *     path="/transactions",
 *     summary="Get User Transactions",
 *     tags={"Transactions"},
 *     security={ {"bearerAuth" : {} }},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/TransactionResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Transactions extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $userTransactions = auth()->user()?->userTransactions;

        return TransactionResource::collection($userTransactions);
    }
}
