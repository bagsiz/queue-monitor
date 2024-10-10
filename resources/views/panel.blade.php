<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Monitor Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Queue Monitor Panel</h1>
    <div class="row">
        <div class="col-md-12">
            <h3>Processing Jobs</h3>
            <ul id="processing-jobs" class="list-group">
                @foreach($processingJobs as $jobId => $job)
                    <li class="list-group-item">{{ json_decode($job, true)['name'] }} (Started at: {{ json_decode($job, true)['started_at'] }})</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12">
            <h3>Processed Jobs</h3>
            <ul id="processed-jobs" class="list-group">
                @foreach($processedJobs as $jobId => $job)
                    <li class="list-group-item">{{ json_decode($job, true)['name'] }} (Started at: {{ json_decode($job, true)['started_at'] }})</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12">
            <h3>Failed Jobs</h3>
            <ul id="failed-jobs" class="list-group">
                @foreach($failedJobs as $jobId => $job)
                    <li class="list-group-item">{{ json_decode($job, true)['name'] }} (Started at: {{ json_decode($job, true)['started_at'] }})</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let reload = function () {
            location.reload();
        };

        setInterval(reload, 5000);
    });
</script>
</body>
</html>
