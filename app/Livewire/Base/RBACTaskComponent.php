<?php

namespace App\Livewire\Base;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Traits\RBACHelpers;
use App\Services\RBACService;

/**
 * Base component for RBAC-aware task components
 * Provides consistent permission handling and data formatting
 */
abstract class RBACTaskComponent extends Component
{
    use Interactions, RBACHelpers;

    // Permission properties
    public $canEdit = false;
    public $canDelete = false;
    public $canCreate = false;
    public $isViewOnly = true;

    // Context for RBAC
    public $context = 'global';

    public function mount()
    {
        $this->initializeRBAC();
        $this->bootComponent();
    }

    /**
     * Override this method in child components for specific initialization
     */
    protected function bootComponent()
    {
        //
    }

    /**
     * Standard method to load task data with RBAC
     */
    protected function loadTaskWithRBAC($taskId, $context = 'global')
    {
        $this->context = $context;
        
        $task = \App\Models\Task::with(['assignee', 'project'])->findOrFail($taskId);
        
        // Check view permission first
        if (!RBACService::canViewTask($task)) {
            $this->toast()->error('Error', 'You do not have permission to view this task')->send();
            return null;
        }

        // Set permissions
        $this->setTaskPermissions($task);
        
        return $task;
    }

    /**
     * Standard method to load assignable users based on context and permissions
     */
    protected function loadAssignableUsers($project = null, $currentAssignedId = null)
    {
        $users = RBACService::getAssignableUsers($project, null, $this->context);
        return $this->getFormattedUsers($users, $currentAssignedId);
    }

    /**
     * Check if user can edit assignment field
     */
    public function canEditAssignment()
    {
        $user = auth()->user();
        
        // Super admin and admin can always edit assignments
        if (RBACService::isSuperAdminOrAdmin($user)) {
            return true;
        }

        // Basic users in project context can't edit assignments
        if ($this->context === 'project' && RBACService::isBasic($user)) {
            return false;
        }

        return false;
    }
}
