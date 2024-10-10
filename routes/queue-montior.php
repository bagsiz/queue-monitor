<?php

use Illuminate\Support\Facades\Route;
use Bagsiz\QueueMonitor\Controllers\QueueMonitorController;

Route::get('queue-monitor', [QueueMonitorController::class, 'index'])->name('queue-monitor.index');
