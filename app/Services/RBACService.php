<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class RBACService
{
    const ROLE_SUPER_ADMIN = 3;
    const ROLE_ADMIN = 1;
    const ROLE_BASIC = 2;

    /**
     * Check if user is super admin
     */
    public static function isSuperAdmin(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        return $user && $user->hasRole([self::ROLE_SUPER_ADMIN]);
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        return $user && $user->hasRole([self::ROLE_ADMIN]);
    }

    /**
     * Check if user is basic
     */
    public static function isBasic(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        return $user && $user->hasRole([self::ROLE_BASIC]);
    }

    /**
     * Check if user is super admin or admin
     */
    public static function isSuperAdminOrAdmin(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        return $user && $user->hasRole([self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
    }

    /**
     * Check if user can create tasks in a project
     */
    public static function canCreateTask(?Project $project = null, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        // Super admin and admin can always create tasks
        if (self::isSuperAdminOrAdmin($user)) {
            return true;
        }

        // Basic users can create tasks if they're assigned to the project (or globally for My Tasks)
        if (self::isBasic($user)) {
            if (!$project) {
                return true; // For My Tasks page
            }
            return $user->projects->contains($project->id);
        }

        return false;
    }

    /**
     * Check if user can edit a task
     */
    public static function canEditTask(Task $task, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        // Super admin and admin can edit any task
        if (self::isSuperAdminOrAdmin($user)) {
            return true;
        }

        // Basic users can only edit their own tasks
        if (self::isBasic($user)) {
            return $task->assigned_to == $user->id;
        }

        return false;
    }

    /**
     * Check if user can delete a task
     */
    public static function canDeleteTask(Task $task, ?User $user = null): bool
    {
        // Same logic as edit for now
        return self::canEditTask($task, $user);
    }

    /**
     * Check if user can view a task
     */
    public static function canViewTask(Task $task, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        // Super admin and admin can view any task
        if (self::isSuperAdminOrAdmin($user)) {
            return true;
        }

        // Basic users can view tasks in projects they're assigned to
        if (self::isBasic($user)) {
            return $user->projects->contains($task->project_id) || $task->assigned_to === $user->id;
        }

        return false;
    }

    /**
     * Check if user can drag/drop tasks
     */
    public static function canMoveTask(Task $task, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        
        // Super admin and admin can move any task
        if (self::isSuperAdminOrAdmin($user)) {
            return true;
        }

        // Basic users can only move their own tasks
        if (self::isBasic($user)) {
            return $task->assigned_to === $user->id;
        }

        return false;
    }

    /**
     * Get assignable users for task creation/editing
     */
    public static function getAssignableUsers(?Project $project = null, ?User $user = null, ?string $context = null): array
    {
        $user = $user ?? Auth::user();
        
        // For "My Tasks" context, EVERYONE can only assign to themselves
        if ($context === 'global') {
            return [['id' => $user->id, 'name' => $user->name]];
        }
        
        // For project context, apply role-based logic
        // Basic users can only assign to themselves
        if (self::isBasic($user)) {
            return [['id' => $user->id, 'name' => $user->name]];
        }
        
        // Admin/Super admin users in project context
        if (self::isSuperAdminOrAdmin($user)) {
            if ($project) {
                // Get all project users
                $projectUsers = $project->users()->select('id', 'name')->get()->toArray();
                
                // Always add the current user if not in project users
                $currentUserInProject = collect($projectUsers)->contains('id', $user->id);
                if (!$currentUserInProject) {
                    $projectUsers[] = ['id' => $user->id, 'name' => $user->name];
                }
                
                // For admin users, also add other admin users to the project context
                $adminUsers = User::whereHas('roles', function($query) {
                    $query->whereIn('id', [2, 3]); // Admin and Super Admin roles
                })->select('id', 'name')->get()->toArray();
                
                foreach ($adminUsers as $adminUser) {
                    if (!collect($projectUsers)->contains('id', $adminUser['id'])) {
                        $projectUsers[] = $adminUser;
                    }
                }
                
                return $projectUsers;
            }
            // No project specified, return all users
            return User::select('id', 'name')->get()->toArray();
        }

        return [['id' => $user->id, 'name' => $user->name]]; // Default fallback
    }

    /**
     * Get projects user can filter by
     */
    public static function getFilterableProjects(?User $user = null): array
    {
        $user = $user ?? Auth::user();
        
        // Super admin and admin can see all projects
        if (self::isSuperAdminOrAdmin($user)) {
            return Project::select('id', 'title')->get()->toArray();
        }

        // Basic users can only see projects they're assigned to
        if (self::isBasic($user)) {
            return $user->projects()->select('id', 'title')->get()->toArray();
        }

        return [];
    }

    /**
     * Get projects user can create tasks in
     */
    public static function getTaskCreationProjects(?User $user = null): array
    {
        // Same as filterable projects for now
        return self::getFilterableProjects($user);
    }

    /**
     * Apply task filtering based on user role
     */
    public static function applyTaskFiltering($query, ?Project $project = null, ?User $user = null, ?string $context = null)
    {
        $user = $user ?? Auth::user();
        
        // For "My Tasks" context (global), all users should only see their own tasks
        if ($context === 'global' || (!$project && !$context)) {
            return $query->where('assigned_to', $user->id);
        }
        
        // For project context, apply role-based filtering
        if (self::isSuperAdminOrAdmin($user)) {
            return $query;
        }

        // Basic users can only see tasks they're assigned to or in projects they're part of
        if (self::isBasic($user)) {
            if ($project) {
                // In project context, show tasks from projects they're assigned to
                return $query->whereIn('project_id', $user->projects->pluck('id'));
            } else {
                // Fallback to own tasks
                return $query->where('assigned_to', $user->id);
            }
        }

        return $query;
    }
}
