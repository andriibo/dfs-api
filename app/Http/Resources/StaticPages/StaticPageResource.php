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
            'title' => $this->title,
            'content' => $this->content,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'linkText' => $this->link_text,
        ];
    }
}
