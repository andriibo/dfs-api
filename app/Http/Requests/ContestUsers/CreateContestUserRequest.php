<?php

namespace App\Http\Requests\ContestUsers;

use App\Http\Requests\AbstractFormRequest;
use App\Repositories\ContestRepository;
use App\Rules\ContestUnitsBelongsToContestRule;
use App\Rules\ContestUnitsInTeamRule;
use App\Rules\ContestUnitsNumberInPositionRule;
use App\Rules\ContestUnitsPositionsRule;
use App\Rules\ContestUnitsSalaryRule;
use App\Rules\ContestUnitsUniqueRule;
use FantasySports\SportConfig\Factories\SportConfigFactory;

/**
 * @OA\RequestBody(
 *    request="CreateContestUserRequest",
 *    required=true,
 *    @OA\JsonContent(required={"contestId", "units"},
 *      @OA\Property(property="contestId", type="integer", example="5"),
 *      @OA\Property(property="units", type="array",
 *          @OA\Items(required={"id","position"},
 *              @OA\Property(property="id", type="integer", example="23"),
 *              @OA\Property(property="position", type="string", example="Goalkeeper")
 *          )
 *      )
 *    )
 * )
 */
class CreateContestUserRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        $contestRepository = new ContestRepository();
        $contest = $contestRepository->getContestById($this->input('contestId'));
        $sportConfig = SportConfigFactory::getConfig($contest->league->sport_id);

        return [
            'contestId' => 'required|integer|exists:contest,id',
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
            'units.*.position' => 'required|string',
        ];
    }
}
