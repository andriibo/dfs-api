<?php

namespace App\OA;

/**
 * @OA\Parameter(
 *    name="accept",
 *    in="header",
 *    description="Accept header",
 *    @OA\Schema(type="string", example="application/vnd.api+json")
 * )
 * @OA\Parameter(
 *    name="сontentType",
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
 *    name="contestSort",
 *    description="Use 'sort' key",
 *    in="path",
 *    @OA\Schema(type="string", enum={"(-)title","(-)salaryCap", "(-)entries", "(-)entryFee", "(-)prizeBank", "(-)startDate"})
 * )
 * @OA\Parameter(
 *    name="userTransactionSort",
 *    description="Use 'sort' key",
 *    in="path",
 *    @OA\Schema(type="string", enum={"(-)createdAt","(-)updatedAt"})
 * )
 */
class ParametersOA
{
}
