# Bagsiz Queue Monitor

## Overview
Bagsiz Queue Monitor is a Laravel package for monitoring the status of your queue jobs. It tracks jobs that are processing, completed, and failed, and provides a simple dashboard to view job statuses in real time.

## Installation
1. Install the package via Composer:
   ```
   composer require Bagsiz/queue-monitor
   ```

2. Publish the configuration and view files:
   ```
   php artisan vendor:publish --provider="Bagsiz\QueueMonitor\QueueMonitorServiceProvider"
   ```

3. Add the service provider in your `config/app.php` file if it is not automatically added:
   ```php
   'providers' => [
       // Other service providers...
       Bagsiz\QueueMonitor\QueueMonitorServiceProvider::class,
   ],
   ```

## Usage
- To view the queue monitor panel, navigate to `/queue-monitor` in your application.
- The dashboard will provide real-time information about processing, completed, and failed jobs.

## Configuration
The package comes with a configuration file (`queue-monitor.php`) that can be customized after publishing. You can change settings like:
- `log_channel`: Specify the log channel to use.

## Example
The monitoring panel is accessible at `/queue-monitor`. It shows:
- **Processing Jobs**: Jobs that are currently in progress.
- **Processed Jobs**: Jobs that have been completed.
- **Failed Jobs**: Jobs that have failed, along with error details.

## License
This package is open-sourced software licensed under the [MIT license](LICENSE).
