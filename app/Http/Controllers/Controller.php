<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Fantasysports OpenApi Documentation",
 *      description="Fantasysports RESTful API"
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Fantasysports API Server",
 *      @OA\ServerVariable(
 *         serverVariable="schema",
 *         enum={"https", "http"},
 *         default="https"
 *      )
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      description="Enter your bearer token in the format **Bearer {{token}}**",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * ),
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Auth"
 * )
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints of Users"
 * )
 * @OA\Tag(
 *     name="Leagues",
 *     description="API Endpoints of Leagues"
 * )
 * @OA\Tag(
 *     name="Contests",
 *     description="API Endpoints of Contests"
 * )
 * @OA\Tag(
 *     name="Contest Users",
 *     description="API Endpoints of Contest Users"
 * )
 * @OA\Tag(
 *     name="Transactions",
 *     description="API Endpoints of Transactions"
 * )
 * @OA\Tag(
 *     name="Static Pages",
 *     description="API Endpoints of Static Pages"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
