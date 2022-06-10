<?php

namespace App\Http\Requests\ResourceQuery;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Parameter(
 *    name="page",
 *    in="query",
 *    style="deepObject",
 *    explode=true,
 *    @OA\Schema(
 *       @OA\Property(property="number", type="integer", minimum=1, example="1"),
 *       @OA\Property(property="size", type="integer", minimum=1, maximum=100, example="10")
 *    )
 * )
 */
class GetCollectionQuery extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'nullable|array',
            'page.number' => 'filled|integer|min:1',
            'page.size' => 'filled|integer|between:1,100',
        ];
    }
}
