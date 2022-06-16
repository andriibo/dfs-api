<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\Contests\ContestResource;
use App\Models\Contests\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushContestUpdatedJob implements ShouldQueue
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
            $resource = new ContestResource($this->contest);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendContestUpdatePush($resource->jsonSerialize());
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
