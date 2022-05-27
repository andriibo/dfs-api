<?php

namespace App\Http\Resources\ContestUnits;

use App\Factories\SportConfigFactory;
use App\Helpers\FileHelper;
use App\Helpers\UnitStatsHelper;
use App\Http\Resources\GameSchedules\GameScheduleResource;
use App\Http\Resources\Leagues\PositionResource;
use App\Http\Resources\Teams\TeamResource;
use App\Http\Resources\UnitStats\StatsResource;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\Cricket\CricketTeam;
use App\Models\Cricket\CricketUnit;
use App\Models\Soccer\SoccerGameSchedule;
use App\Models\Soccer\SoccerTeam;
use App\Models\Soccer\SoccerUnit;
use App\Services\NextGameScheduleForTeamService;
use App\Services\TeamService;
use App\Services\UnitService;
use App\Services\UnitStatsService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ContestUnitDetailsResource",
 *     @OA\Property(property="id", type="integer", example="21"),
 *     @OA\Property(property="fullname", type="string", example="David Olatukunbo Alaba"),
 *     @OA\Property(property="photo", type="string"),
 *     @OA\Property(property="salary", type="number", format="double", example="5000.45"),
 *     @OA\Property(property="totalFantasyPoints", type="number", format="double", example="15.06"),
 *     @OA\Property(property="totalFantasyPointsPerGame", type="number", format="double", example="11.16"),
 *     @OA\Property(property="sportId", type="integer", enum={1,2,3}, description="1 - Soccer, 2- Football, 3 - Cricket"),
 *     @OA\Property(property="position", ref="#/components/schemas/PositionResource"),
 *     @OA\Property(property="team", ref="#/components/schemas/TeamResource"),
 *     @OA\Property(property="nextGameSchedule", ref="#/components/schemas/GameScheduleResource"),
 *     @OA\Property(property="lastGameStats", type="array", @OA\Items(ref="#/components/schemas/StatsResource")),
 *     @OA\Property(property="lastFiveGamesStats", type="array", @OA\Items(ref="#/components/schemas/StatsResource")),
 *     @OA\Property(property="totalStats", type="array", @OA\Items(ref="#/components/schemas/StatsResource"))
 * )
 */
class ContestUnitDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        $unit = $this->getUnit();
        $team = $this->getTeam();
        $nextGameScheduleForTeam = $this->getNextGameSchedule();
        $sportConfig = SportConfigFactory::getConfig($this->sport_id);
        [$totalStats, $lastFiveGamesStats, $lastGameStats] = $this->getStats($unit);

        return [
            'id' => $this->id,
            'fullname' => $unit->player->getFullName(),
            'photo' => FileHelper::getPublicUrl($unit->player->photo),
            'salary' => (float) $unit->player->salary,
            'totalFantasyPoints' => (float) $unit->player->total_fantasy_points,
            'totalFantasyPointsPerGame' => (float) $unit->player->total_fantasy_points_per_game,
            'sportId' => $this->sport_id,
            'position' => new PositionResource($sportConfig->positions[$unit->position] ?? null),
            'team' => new TeamResource($team),
            'nextGameSchedule' => new GameScheduleResource($nextGameScheduleForTeam),
            'lastGameStats' => StatsResource::collection($lastGameStats),
            'lastFiveGamesStats' => StatsResource::collection($lastFiveGamesStats),
            'totalStats' => StatsResource::collection($totalStats),
        ];
    }

    private function getStats(SoccerUnit|CricketUnit $unit): array
    {
        $totalUnitStats = $unit->totalUnitStats();
        $totalStats = $totalUnitStats
            ? UnitStatsHelper::mapStats($totalUnitStats->stats, $this->contest->actionPoints)
            : [];
        /* @var $unitStatsService UnitStatsService */
        $unitStatsService = resolve(UnitStatsService::class);

        $lastFiveGamesUnitStats = $unitStatsService->getStats($this->resource, 5);
        $lastGameUnitStats = $lastFiveGamesUnitStats->first();
        $lastFiveGamesUnitStats = $lastFiveGamesUnitStats->pluck('stats')->toArray();
        $lastFiveGamesUnitStats = UnitStatsHelper::sumStats($lastFiveGamesUnitStats);
        $lastFiveGamesStats = UnitStatsHelper::mapStats($lastFiveGamesUnitStats, $this->contest->actionPoints);
        $lastGameStats = UnitStatsHelper::mapStats($lastGameUnitStats->stats, $this->contest->actionPoints);

        return [
            $totalStats,
            $lastFiveGamesStats,
            $lastGameStats,
        ];
    }

    private function getTeam(): CricketTeam|SoccerTeam
    {
        /* @var $teamService TeamService */
        $teamService = resolve(TeamService::class);

        return $teamService->getTeam($this->resource);
    }

    private function getUnit(): CricketUnit|SoccerUnit
    {
        /* @var $unitService UnitService */
        $unitService = resolve(UnitService::class);

        return $unitService->getUnit($this->resource);
    }

    private function getNextGameSchedule(): null|SoccerGameSchedule|CricketGameSchedule
    {
        /* @var $nextGameScheduleForTeam NextGameScheduleForTeamService */
        $nextGameScheduleForTeam = resolve(NextGameScheduleForTeamService::class);

        return $nextGameScheduleForTeam->handle($this->resource);
    }
}
