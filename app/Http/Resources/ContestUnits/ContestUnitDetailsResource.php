<?php

namespace App\Http\Resources\ContestUnits;

use App\Factories\SportConfigFactory;
use App\Helpers\UnitStatsHelper;
use App\Http\Resources\GameSchedules\GameScheduleResource;
use App\Services\NextGameScheduleForTeamService;
use App\Services\TeamService;
use App\Services\UnitService;
use App\Services\UnitStatsService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestUnitDetailsResource",
 *     @OA\Property(property="id", type="integer", example="21"),
 *     @OA\Property(property="playerId", type="integer", example="45"),
 *     @OA\Property(property="totalFantasyPointsPerGame", type="number", format="double", example="11.16"),
 *     @OA\Property(property="salary", type="number", format="double", example="5000.45"),
 *     @OA\Property(property="score", type="number", format="double", example="50.45"),
 *     @OA\Property(property="fullname", type="string", example="David Olatukunbo Alaba"),
 *     @OA\Property(property="position", type="integer", example="1"),
 *     @OA\Property(property="photo", type="string"),
 *     @OA\Property(property="teamId", type="number", example="34")
 * )
 */
class ContestUnitDetailsResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        /* @var $unitService UnitService
        * @var $teamService TeamService
        * @var $nextGameScheduleForTeam NextGameScheduleForTeamService  */
        $unitService = resolve(UnitService::class);
        $teamService = resolve(TeamService::class);
        $nextGameScheduleForTeam = resolve(NextGameScheduleForTeamService::class);
        $unit = $unitService->getUnit($this->resource);
        $totalUnitStats = $unit->totalUnitStats();
        $lastFiveGamesUnitStats = $this->getLastFiveUnitStats();
        $team = $teamService->getTeam($this->resource);
        $sportConfig = SportConfigFactory::getConfig($this->sport_id);
        $totalStats = $totalUnitStats ? $totalUnitStats->stats : [];

        return [
            'id' => $this->id,
            'totalFantasyPointsPerGame' => $unit->player->total_fantasy_points_per_game,
            'totalFantasyPoints' => $unit->player->total_fantasy_points,
            'salary' => $unit->player->salary,
            'fullname' => $unit->player->getFullName(),
            'position' => $sportConfig->positions[$unit->position] ?? null,
            'photo' => $unit->player->photo?->getFileUrl(),
            'team' => $team->name,
            'nextGameSchedule' => new GameScheduleResource($nextGameScheduleForTeam->handle($this->contest_id, $this->team_id)),
            'totalStats' => UnitStatsHelper::mapStats($totalStats, $this->contest->actionPoints),
        ];
    }

    private function getLastFiveUnitStats()
    {
        /* @var $unitStatsService UnitStatsService */
        $unitStatsService = resolve(UnitStatsService::class);
        $lastFiveUnitStats = $unitStatsService->getStats($this->resource, 5);
    }
}
