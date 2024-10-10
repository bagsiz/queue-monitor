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
        <div class="col-md-4">
            <h3>Processing Jobs</h3>
            <ul id="processing-jobs" class="list-group">
                <!-- Processing jobs will be appended here -->
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Processed Jobs</h3>
            <ul id="processed-jobs" class="list-group">
                <!-- Processed jobs will be appended here -->
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Failed Jobs</h3>
            <ul id="failed-jobs" class="list-group">
                <!-- Failed jobs will be appended here -->
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function fetchJobs() {
            axios.get('/queue-monitor/api/jobs').then(response => {
                const data = response.data;
                // Clear the lists
                document.getElementById('processing-jobs').innerHTML = '';
                document.getElementById('processed-jobs').innerHTML = '';
                document.getElementById('failed-jobs').innerHTML = '';
                
                // Append processing jobs
                for (const jobId in data.processing) {
                    const job = data.processing[jobId];
                    document.getElementById('processing-jobs').innerHTML += `<li class="list-group-item">${job.name} (Started at: ${job.started_at})</li>`;
                }
                // Append processed jobs
                for (const jobId in data.processed) {
                    const job = data.processed[jobId];
                    document.getElementById('processed-jobs').innerHTML += `<li class="list-group-item">${job.name} (Completed at: ${job.completed_at})</li>`;
                }
                // Append failed jobs
                for (const jobId in data.failed) {
                    const job = data.failed[jobId];
                    document.getElementById('failed-jobs').innerHTML += `<li class="list-group-item">${job.name} (Failed at: ${job.failed_at}) - ${job.exception}</li>`;
                }
            });
        }

        // Fetch jobs every 5 seconds
        setInterval(fetchJobs, 5000);
        fetchJobs();
    });
</script>
</body>
</html>
