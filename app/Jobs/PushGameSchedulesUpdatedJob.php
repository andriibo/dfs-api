<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\GameSchedules\GameScheduleResource;
use App\Models\Contests\Contest;
use App\Services\GameScheduleService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushGameSchedulesUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly Contest $contest)
    {
    }

    public function handle(): void
    {
        try {
            /* @var $gameScheduleService GameScheduleService */
            $gameScheduleService = resolve(GameScheduleService::class);
            $gameSchedules = $gameScheduleService->getGameSchedules($this->contest);
            $collection = GameScheduleResource::collection($gameSchedules);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendGameSchedulesUpdatePush($collection->jsonSerialize(), $this->contest->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
