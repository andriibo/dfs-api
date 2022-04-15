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
 *
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
 *     name="Users",
 *     description="API Endpoints of Users"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
