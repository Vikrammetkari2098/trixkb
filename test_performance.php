<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Task;
use Carbon\Carbon;

echo "Performance Test for Task Optimizations\n";
echo "=====================================\n\n";

// Test 1: Single Query Performance
echo "Test 1: Measuring database query performance...\n";
$start = microtime(true);

// Test the optimized batch query
$statusCounts = Task::selectRaw('
    status,
    COUNT(*) as count
')->groupBy('status')->pluck('count', 'status');

$taskTypeCounts = Task::selectRaw('
    status,
    task_type_id,
    COUNT(*) as count,
    SUM(CASE WHEN due_date < NOW() AND status IN (1,2,3) THEN 1 ELSE 0 END) as overdue_count
')->groupBy('status', 'task_type_id')->get();

$queryTime = microtime(true) - $start;
echo "Batch query time: " . round($queryTime * 1000, 2) . "ms\n";

// Test 2: Memory usage
echo "\nTest 2: Memory usage...\n";
echo "Memory used: " . round(memory_get_usage(true) / 1024 / 1024, 2) . "MB\n";
echo "Peak memory: " . round(memory_get_peak_usage(true) / 1024 / 1024, 2) . "MB\n";

// Test 3: Cache performance
echo "\nTest 3: Cache performance...\n";
$cacheKey = 'task_statistics_' . md5(serialize([]));

$start = microtime(true);
$cached = cache()->remember($cacheKey, 300, function () use ($statusCounts, $taskTypeCounts) {
    return [
        'status' => $statusCounts,
        'taskTypes' => $taskTypeCounts,
        'total' => Task::count()
    ];
});
$cacheTime = microtime(true) - $start;
echo "Cache operation time: " . round($cacheTime * 1000, 2) . "ms\n";

// Test 4: Optimized relationship loading
echo "\nTest 4: Optimized relationship loading...\n";
$start = microtime(true);
$tasks = Task::with(['assignee:id,name', 'project:id,title', 'statusInfo:id,name', 'taskType:id,name', 'priority:id,name'])
    ->withCount(['comments', 'docs'])
    ->limit(10)
    ->get();
$relationshipTime = microtime(true) - $start;
echo "Optimized relationship loading time: " . round($relationshipTime * 1000, 2) . "ms\n";
echo "Tasks loaded: " . $tasks->count() . "\n";

echo "\n✅ Performance test completed!\n";
echo "The optimizations should show:\n";
echo "- Reduced query time from multiple individual queries to 2 batch queries\n";
echo "- Efficient memory usage with selective column loading\n";
echo "- Fast cache operations\n";
echo "- Optimized relationship loading\n";
