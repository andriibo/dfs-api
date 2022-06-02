<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="UpdateUserAvatarRequest",
 *    required=true,
 *    @OA\MediaType(
 *      mediaType="multipart/form-data",
 *      @OA\Schema(required={"image"},
 *         @OA\Property(property="image", type="string", format="binary", maximum=10485760)
 *      )
 *   )
 * )
 */
class UpdateUserAvatarRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|mimes:png,jpg,gif,svg|max:10485760',
        ];
    }
}
