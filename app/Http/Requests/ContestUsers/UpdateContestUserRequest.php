<?php

namespace App\Http\Requests\ContestUsers;

use App\Factories\SportConfigFactory;
use App\Http\Requests\AbstractFormRequest;
use App\Repositories\ContestUserRepository;
use App\Rules\ContestUnitsInTeamRule;
use App\Rules\ContestUnitsNumberInPositionRule;
use App\Rules\ContestUnitsPositionsRule;
use App\Rules\ContestUnitsSalaryRule;
use App\Rules\ContestUnitsUniqueRule;

/**
 * @OA\RequestBody(
 *    request="UpdateContestUserRequest",
 *    required=true,
 *    @OA\JsonContent(required={"units"},
 *      @OA\Property(property="units", type="array",
 *          @OA\Items(required={"id","position"},
 *              @OA\Property(property="id", type="integer", example="23"),
 *              @OA\Property(property="position", type="string", example="Goalkeeper")
 *          )
 *      )
 *    )
 * )
 */
class UpdateContestUserRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        $contestRepository = new ContestUserRepository();
        $contestUser = $contestRepository->getById($this->route('id'));
        $sportConfig = SportConfigFactory::getConfig($contestUser->contest->league->sport_id);

        return [
            'units' => [
                'present',
                'array',
                new ContestUnitsPositionsRule($contestUser->contest, $sportConfig),
                new ContestUnitsUniqueRule(),
                new ContestUnitsInTeamRule($sportConfig),
                new ContestUnitsSalaryRule($contestUser->contest),
                new ContestUnitsNumberInPositionRule($sportConfig),
            ],
            'units.*.id' => 'required|integer',
            'units.*.position' => 'required|string',
        ];
    }
}
