<?php

namespace App\Http\Resources\Transactions;

use App\Helpers\UserTransactionHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TransactionResource",
 *     @OA\Property(property="id", type="integer", example="12"),
 *     @OA\Property(property="amount", type="number", format="double", example="230.41"),
 *     @OA\Property(property="status", type="integer", enum={0,1,2,3,4,5}),
 *     @OA\Property(property="type", type="integer", enum={1,2,3,4,5,6,7,8,9,10,11,12}),
 *     @OA\Property(property="createdAt", type="string", example="2022-04-01 12:00:05"),
 *     @OA\Property(property="updatedAt", type="string", example="2022-04-02 11:59:41")
 * )
 */
class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => UserTransactionHelper::getAmount($this->resource),
            'status' => $this->status,
            'type' => $this->type,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
