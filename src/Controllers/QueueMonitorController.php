<?php

namespace Bagsiz\QueueMonitor\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redis;

class QueueMonitorController extends Controller
{
    public function index()
    {
        $processingJobs = Redis::connection(config('queue-monitor.redis_connection'))->hgetall('queue:jobs:processing');
        $processedJobs = Redis::connection(config('queue-monitor.redis_connection'))->hgetall('queue:jobs:processed');
        $failedJobs = Redis::connection(config('queue-monitor.redis_connection'))->hgetall('queue:jobs:failed');

        return view('vendor.queue-monitor.panel', [
            'processingJobs' => $processingJobs,
            'processedJobs' => $processedJobs,
            'failedJobs' => $failedJobs,
        ]);
    }
}
