<?php

namespace App\OA;

/**
 * @OA\Schema(
 *   title="PaginationSchemaOA",
 *   @OA\Property(property="links",
 *      @OA\Property(property="first", type="string"),
 *      @OA\Property(property="last", type="string"),
 *      @OA\Property(property="prev", type="string", nullable=true),
 *      @OA\Property(property="next", type="string", nullable=true)
 *   ),
 *   @OA\Property(property="meta", type="object",
 *      @OA\Property(property="currentPage", type="integer", example="1"),
 *      @OA\Property(property="from", type="integer", example="1"),
 *      @OA\Property(property="lastPage", type="integer", example="10"),
 *      @OA\Property(property="links", type="array", @OA\Items(
 *          @OA\Property(property="url", type="string", nullable=true),
 *          @OA\Property(property="label", type="string"),
 *          @OA\Property(property="active", type="boolean", example="true")
 *      )),
 *      @OA\Property(property="path", type="string"),
 *      @OA\Property(property="perPage", type="integer", example="5"),
 *      @OA\Property(property="to", type="integer", example="2"),
 *      @OA\Property(property="total", type="integer", example="50")
 *   )
 * )
 */
class PaginationSchemaOA
{
}
