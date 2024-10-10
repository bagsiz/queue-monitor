<?php

namespace Bagsiz\QueueMonitor;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Bagsiz\QueueMonitor\Services\QueueMonitorService;

class QueueMonitorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register queue events
        $this->registerEvents();

        // Register routes
        $this->loadRoutesFrom(__DIR__.'/routes/queue-monitor.php');

        // Publish the config file if users need to customize settings
        $this->publishes([
            __DIR__.'/config/queue-monitor.php' => config_path('queue-monitor.php'),
        ], 'config');

        // Publish the view files for the monitoring panel
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/queue-monitor'),
        ], 'views');
    }

    public function register()
    {
        // Merge default configuration
        $this->mergeConfigFrom(__DIR__.'/config/queue-monitor.php', 'queue-monitor');

        // Bind the QueueMonitorService
        $this->app->singleton(QueueMonitorService::class, function ($app) {
            return new QueueMonitorService();
        });
    }

    private function registerEvents()
    {
        $queueMonitorService = $this->app->make(QueueMonitorService::class);

        // Listen for job processing events
        $this->app['events']->listen(JobProcessing::class, function (JobProcessing $event) use ($queueMonitorService) {
            $queueMonitorService->handleJobProcessing($event);
        });

        // Listen for job processed events
        $this->app['events']->listen(JobProcessed::class, function (JobProcessed $event) use ($queueMonitorService) {
            $queueMonitorService->handleJobProcessed($event);
        });

        // Listen for job failed events
        $this->app['events']->listen(JobFailed::class, function (JobFailed $event) use ($queueMonitorService) {
            $queueMonitorService->handleJobFailed($event);
        });
    }
}
