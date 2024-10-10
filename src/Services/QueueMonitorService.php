<?php

namespace Bagsiz\QueueMonitor\Services;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Redis;

class QueueMonitorService
{
    public function handleJobProcessing(JobProcessing $event)
    {
        /**
         * @var JobProcessing $event
         * $event->connectionName: The name of the connection the job belongs to.
         * $event->job: The job instance that is being processed.
         */
        Redis::connection(config('queue-monitor.redis_connection'))
            ->hset('queue:jobs:processing', $event->job->getJobId(), json_encode([
                'connection' => $event->connectionName,
                'name' => $event->job->resolveName(),
                'payload' => $event->job->payload(),
                'started_at' => now()->toDateTimeString(),
        ]));
    }

    public function handleJobProcessed(JobProcessed $event)
    {
        /**
         * @var JobProcessed $event
         * $event->connectionName: The name of the connection the job belongs to.
         * $event->job: The job instance that was processed.
         */
        Redis::connection(config('queue-monitor.redis_connection'))->hdel('queue:jobs:processing', $event->job->getJobId());
        Redis::connection(config('queue-monitor.redis_connection'))
            ->hset('queue:jobs:processed', $event->job->getJobId(), json_encode([
                'connection' => $event->connectionName,
                'name' => $event->job->resolveName(),
                'payload' => $event->job->payload(),
                'completed_at' => now()->toDateTimeString(),
        ]));
    }

    public function handleJobFailed(JobFailed $event)
    {
        /**
         * @var JobFailed $event
         * $event->connectionName: The name of the connection the job belongs to.
         * $event->job: The job instance that failed.
         * $event->exception: The exception that caused the job to fail.
         */
        Redis::connection(config('queue-monitor.redis_connection'))->hdel('queue:jobs:processing', $event->job->getJobId());
        Redis::connection(config('queue-monitor.redis_connection'))
            ->hset('queue:jobs:failed', $event->job->getJobId(), json_encode([
                'connection' => $event->connectionName,
                'name' => $event->job->resolveName(),
                'payload' => $event->job->payload(),
                'failed_at' => now()->toDateTimeString(),
                'exception' => $event->exception->getMessage(),
        ]));
    }
}
