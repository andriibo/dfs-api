<?php

namespace App\Http\Requests\Contests;

use App\Factories\SportConfigFactory;
use App\Http\Requests\AbstractFormRequest;
use App\Repositories\ContestRepository;
use App\Rules\ContestUnitsBelongsToContestRule;
use App\Rules\ContestUnitsInTeamRule;
use App\Rules\ContestUnitsNumberInPositionRule;
use App\Rules\ContestUnitsPositionsRule;
use App\Rules\ContestUnitsSalaryRule;
use App\Rules\ContestUnitsUniqueRule;

/**
 * @OA\RequestBody(
 *    request="UnitsRequest",
 *    description="Contest Units request body",
 *    @OA\JsonContent(required={"units"},
 *      @OA\Property(property="units", type="array",
 *          @OA\Items(required={"id","position"},
 *              @OA\Property(property="id", type="integer", example="23"),
 *              @OA\Property(property="position", type="integer", example="1")
 *          )
 *      )
 *    )
 * )
 */
class UnitsRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        $contestRepository = new ContestRepository();
        $contest = $contestRepository->getContestById($this->route('id'));
        $sportConfig = SportConfigFactory::getConfig($contest->league->sport_id);

        return [
            'units' => [
                'present',
                'array',
                new ContestUnitsBelongsToContestRule($contest),
                new ContestUnitsPositionsRule($contest, $sportConfig),
                new ContestUnitsUniqueRule(),
                new ContestUnitsInTeamRule($sportConfig),
                new ContestUnitsSalaryRule($contest),
                new ContestUnitsNumberInPositionRule($sportConfig),
            ],
            'units.*.id' => 'required|integer',
            'units.*.position' => 'required|integer',
        ];
    }
}
