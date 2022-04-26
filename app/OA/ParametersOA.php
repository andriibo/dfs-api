<?php

namespace App\OA;

/**
 * @OA\Parameter(
 *    name="page",
 *    in="query",
 *    style="deepObject",
 *    explode=true,
 *    @OA\Schema(type="object",
 *       @OA\Property(property="number", type="integer", minimum=1, example="1"),
 *       @OA\Property(property="size", type="integer", minimum=1, maximum=30, example="10")
 *    )
 * ),
 * @OA\Parameter(
 *    name="Accept",
 *    in="header",
 *    description="Accept header",
 *    @OA\Schema(type="string", example="application/vnd.api+json")
 * )
 * @OA\Parameter(
 *    name="Content-Type",
 *    in="header",
 *    description="Content-Type header",
 *    @OA\Schema(type="string", example="application/vnd.api+json")
 * )
 * @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    @OA\Schema(type="integer", example="11")
 * )
 * @OA\Parameter(
 *    name="hash",
 *    required=true,
 *    in="path",
 *    @OA\Schema(type="string", example="12qs850keo23")
 * )
 */
class ParametersOA
{
}
