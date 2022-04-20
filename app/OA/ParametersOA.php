<?php

namespace App\OA;

/**
 * @OA\Parameter(
 *    name="Accept",
 *    in="header",
 *    description="Accept header",
 *    @OA\Schema(type="string", example="application/vnd.api+json")
 * ),
 * @OA\Parameter(
 *    name="Content-Type",
 *    in="header",
 *    description="Content-Type header",
 *    @OA\Schema(type="string", example="application/vnd.api+json")
 * ),
 * @OA\Parameter(
 *    name="id",
 *    required=true,
 *    in="path",
 *    @OA\Schema(type="integer", example="11")
 * ),
 * @OA\Parameter(
 *    name="hash",
 *    required=true,
 *    in="path",
 *    @OA\Schema(type="string", example="12qs850keo23")
 * ),
 * @OA\Parameter(
 *    name="token",
 *    required=true,
 *    in="query",
 *    @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *    name="email",
 *    required=true,
 *    in="query",
 *    @OA\Schema(type="string")
 * )
 * @OA\Parameter(
 *    name="page[number]",
 *    in="query",
 *    @OA\Schema(type="integer", minimum="1", example="1")
 * )
 * @OA\Parameter(
 *    name="page[size]",
 *    in="query",
 *    @OA\Schema(type="integer", minimum="1", maximum="30", example="10")
 * )
 */
class ParametersOA
{
}
