<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushUserBalanceUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly int $userId)
    {
    }

    public function handle(): void
    {
        try {
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendUserBalanceUpdatePush($this->userId);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
