<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test RBAC logic
$user = App\Models\User::find(2); // Ahmed Arabee - Basic role
$task = App\Models\Task::find(4); // Task assigned to user 2

echo "=== RBAC TEST ===\n";
echo "User: {$user->name} (ID: {$user->id})\n";
echo "User roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "Task: {$task->title} (ID: {$task->id})\n";
echo "Task assigned to: {$task->assigned_to}\n";
echo "\n";

echo "=== ROLE CHECKS ===\n";
echo "Is Super Admin or Admin: " . (App\Services\RBACService::isSuperAdminOrAdmin($user) ? 'YES' : 'NO') . "\n";
echo "Is Basic: " . (App\Services\RBACService::isBasic($user) ? 'YES' : 'NO') . "\n";
echo "\n";

echo "=== PERMISSION CHECKS ===\n";
echo "Can edit task: " . (App\Services\RBACService::canEditTask($task, $user) ? 'YES' : 'NO') . "\n";
echo "Can view task: " . (App\Services\RBACService::canViewTask($task, $user) ? 'YES' : 'NO') . "\n";
echo "Can delete task: " . (App\Services\RBACService::canDeleteTask($task, $user) ? 'YES' : 'NO') . "\n";
echo "\n";

echo "=== ROLE CONSTANTS ===\n";
echo "ROLE_SUPER_ADMIN: " . App\Services\RBACService::ROLE_SUPER_ADMIN . "\n";
echo "ROLE_ADMIN: " . App\Services\RBACService::ROLE_ADMIN . "\n";
echo "ROLE_BASIC: " . App\Services\RBACService::ROLE_BASIC . "\n";
echo "\n";

echo "=== USER ROLE IDS ===\n";
echo "User role IDs: " . $user->roles->pluck('id')->implode(', ') . "\n";
echo "\n";

// Test hasRole method directly
echo "=== hasRole METHOD TEST ===\n";
echo "User hasRole([2]): " . ($user->hasRole([2]) ? 'YES' : 'NO') . "\n";
echo "User hasRole([1]): " . ($user->hasRole([1]) ? 'YES' : 'NO') . "\n";
echo "User hasRole([3]): " . ($user->hasRole([3]) ? 'YES' : 'NO') . "\n";
