<?php

namespace App\Http\Controllers\Api\StaticPages;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPages\StaticPageResource;
use App\Repositories\StaticPageRepository;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Get(
 *     path="/static-pages/{name}",
 *     summary="Get Static Page",
 *     tags={"Static Pages"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(name="name", required=true, in="path", @OA\Schema(type="string", example="faq")),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/StaticPageResource")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Show extends Controller
{
    public function __invoke(string $name, StaticPageRepository $staticPageRepository): JsonResource
    {
        $staticPage = $staticPageRepository->getStaticPageByName($name);

        return new StaticPageResource($staticPage);
    }
}
