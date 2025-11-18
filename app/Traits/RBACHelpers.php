<?php

namespace App\Traits;

use App\Services\RBACService;
use Illuminate\Support\Facades\Auth;

/**
 * Helper trait for RBAC-aware Livewire components
 * Ensures proper initialization and permission handling
 */
trait RBACHelpers
{
    /**
     * Initialize RBAC properties safely
     */
    public function initializeRBAC()
    {
        $this->canEdit = false;
        $this->canDelete = false;
        $this->canCreate = false;
        $this->isViewOnly = true;
    }

    /**
     * Set permissions for a given task
     */
    public function setTaskPermissions($task)
    {
        $this->canEdit = RBACService::canEditTask($task);
        $this->canDelete = RBACService::canDeleteTask($task);
        $this->isViewOnly = !$this->canEdit;
    }

    /**
     * Set permissions for task creation in a project
     */
    public function setCreatePermissions($project = null)
    {
        $this->canCreate = RBACService::canCreateTask($project);
    }

    /**
     * Get users formatted for select components
     * Always ensures string IDs and includes assigned user
     */
    public function getFormattedUsers($users, $assignedUserId = null)
    {
        $formattedUsers = [];
        
        // Always include assigned user first if provided
        if ($assignedUserId) {
            $assignedUser = \App\Models\User::find($assignedUserId);
            if ($assignedUser) {
                $formattedUsers[] = [
                    'id' => (string)$assignedUser->id,
                    'name' => $assignedUser->name
                ];
            }
        }
        
        // Add other users, avoiding duplicates
        foreach ($users as $user) {
            $userId = (string)(is_array($user) ? $user['id'] : $user->id);
            $userName = is_array($user) ? $user['name'] : $user->name;
            
            if (!collect($formattedUsers)->contains('id', $userId)) {
                $formattedUsers[] = ['id' => $userId, 'name' => $userName];
            }
        }
        
        return $formattedUsers;
    }

    /**
     * Check if component is ready to render
     * Prevents rendering with uninitialized data
     */
    public function isReadyToRender()
    {
        return isset($this->taskId) || isset($this->projectId) || $this->isCreateMode ?? false;
    }
}
