<?php

// Tests/Unit/QueueMonitorServiceTest.php
namespace Bagsiz\QueueMonitor\Tests;

use Bagsiz\QueueMonitor\Services\QueueMonitorService;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\TestCase;

class QueueMonitorServiceTest extends TestCase
{
    public function testHandleJobProcessing()
    {
        $event = $this->createMock(JobProcessing::class);
        $event->method('connectionName')->willReturn('redis');
        $event->method('job')->willReturn($this->createMockJob('job-processing'));

        Redis::shouldReceive('hset')->once();
        Log::shouldReceive('info')->once();

        $service = new QueueMonitorService();
        $service->handleJobProcessing($event);
    }

    public function testHandleJobProcessed()
    {
        $event = $this->createMock(JobProcessed::class);
        $event->method('connectionName')->willReturn('redis');
        $event->method('job')->willReturn($this->createMockJob('job-processed'));

        Redis::shouldReceive('hdel')->once();
        Redis::shouldReceive('hset')->once();
        Log::shouldReceive('info')->once();

        $service = new QueueMonitorService();
        $service->handleJobProcessed($event);
    }

    public function testHandleJobFailed()
    {
        $event = $this->createMock(JobFailed::class);
        $event->method('connectionName')->willReturn('redis');
        $event->method('job')->willReturn($this->createMockJob('job-failed'));
        $event->method('exception')->willReturn(new \Exception('Test exception'));

        Redis::shouldReceive('hdel')->once();
        Redis::shouldReceive('hset')->once();
        Log::shouldReceive('error')->once();

        $service = new QueueMonitorService();
        $service->handleJobFailed($event);
    }

    private function createMockJob($name)
    {
        $job = $this->getMockBuilder('Illuminate\\Contracts\\Queue\\Job')
            ->setMethods(['getJobId', 'resolveName'])
            ->getMock();
        $job->method('getJobId')->willReturn('test-job-id');
        $job->method('resolveName')->willReturn($name);
        return $job;
    }
}
