<?php

namespace App\Http\Resources\StaticPages;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="StaticPageResource",
 *     @OA\Property(property="name", type="string", example="privacy"),
 *     @OA\Property(property="title", type="string", example="Privacy Policy"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="keywords", type="string"),
 *     @OA\Property(property="linkText", type="string"),
 * )
 */
class StaticPageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title_en,
            'content' => $this->content_en,
            'description' => $this->description_en,
            'keywords' => $this->keywords_en,
            'linkText' => $this->link_text_en,
        ];
    }
}
