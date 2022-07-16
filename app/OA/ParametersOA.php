<?php

namespace App\OA;

/**
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
 * @OA\Parameter(
 *    name="provider",
 *    required=true,
 *    in="path",
 *    @OA\Schema(type="string", enum={"google","facebook"})
 * )
 * @OA\Parameter(
 *    name="contest-sort",
 *    in="path",
 *    @OA\Schema(type="string", enum={"(-)title","(-)salaryCap", "(-)entries", "(-)entryFee", "(-)prizeBank", "(-)startDate"})
 * )
 * @OA\Parameter(
 *    name="user-transaction-sort",
 *    in="path",
 *    @OA\Schema(type="string", enum={"(-)createdAt","(-)updatedAt"})
 * )
 */
class ParametersOA
{
}
