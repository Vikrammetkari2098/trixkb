# 🔥 Livewire + Alpine.js + TallStackUI Development Guide

A comprehensive guide for building complete CRUD features using Livewire v3, Alpine.js, and TallStackUI in Laravel, with advanced RBAC integration.

---

## 📚 Table of Contents

1. [Architecture Overview](#-architecture-overview)
2. [Project Structure](#-project-structure)
3. [SPA-Style Navigation with wire:navigate](#-spa-style-navigation-with-wirenavigate)
4. [Setting Up a New Feature](#-setting-up-a-new-feature)
5. [Creating Components (CRUD Operations)](#-creating-components-crud-operations)
6. [Frontend Integration](#-frontend-integration)
7. [Component Communication](#-component-communication)
8. [RBAC Integration & Permission Handling](#-rbac-integration--permission-handling)
9. [Advanced Features](#-advanced-features)
10. [Critical Best Practices & Lessons Learned](#-critical-best-practices--lessons-learned)
11. [Common Patterns](#-common-patterns)
12. [Troubleshooting](#-troubleshooting)

---

## 🏗 Architecture Overview

### Tech Stack
- **Livewire v3**: Backend component logic and real-time UI updates
- **Alpine.js**: Minimal reactive JavaScript for frontend interactions
- **TallStackUI**: Pre-built UI components and utilities
- **Tailwind CSS**: Utility-first styling framework
- **RBAC Service**: Role-based access control for permissions

### Communication Flow
```
Frontend (Alpine.js) ↔ Livewire Events ↔ Backend (PHP) ↔ RBAC Service ↔ Database
                    ↓
              TallStackUI Components
```

---

## 📁 Project Structure

### Directory Organization
```
app/Livewire/
├── Base/
│   └── RBACTaskComponent.php  # Base class for RBAC-aware components
├── Auth/
│   ├── LoginUser.php
│   └── RegisterUser.php
├── Project/
│   ├── TaskBoard.php         # Kanban board view
│   ├── TaskList.php          # Table view
│   ├── TaskOverview.php      # Overview/dashboard
│   ├── TaskCreate.php        # Create
│   ├── TaskEdit.php          # Update
│   └── TaskDelete.php        # Delete
├── Projects/
├── Teams/
└── Profile/

app/Services/
└── RBACService.php           # Centralized permission management

app/Traits/
└── RBACHelpers.php           # Helper methods for RBAC components

resources/views/livewire/
├── project/
│   ├── task-board.blade.php
│   ├── task-list.blade.php
│   ├── task-create.blade.php
│   ├── task-edit.blade.php
│   └── task-delete.blade.php
└── components/
    └── conditional-render.blade.php  # Prevents premature rendering
```

### Naming Conventions
- **Components**: `FeatureAction.php` (e.g., `TaskCreate.php`)
- **Views**: `feature/feature-action.blade.php` (e.g., `project/task-create.blade.php`)
- **Events**: `action-feature` (e.g., `delete-task`, `loadTask`)
- **RBAC Methods**: `can{Action}{Feature}` (e.g., `canEditTask`, `canViewTask`)

---

## 🚀 SPA-Style Navigation with wire:navigate

### Overview

Livewire's `wire:navigate` feature transforms your Laravel application into a Single Page Application (SPA) experience while maintaining server-side rendering benefits. This provides 2-3x faster navigation by replacing only the `<body>` content while preserving CSS/JS assets.

### Benefits

- **Performance**: 2-3x faster page loads after initial visit
- **Seamless UX**: No white flashes between pages  
- **Asset Preservation**: CSS/JS files loaded once and cached
- **Laravel Simplicity**: Works with existing routes and controllers
- **SEO Friendly**: Full server-side rendering maintained

### Implementation

#### 1. Basic Navigation Setup

Add `wire:navigate` to navigation links:

```blade
{{-- resources/views/layouts/app.blade.php --}}
<nav>
    <a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
    <a href="{{ route('projects.index') }}" wire:navigate>Projects</a>
    <a href="{{ route('teams.index') }}" wire:navigate>Teams</a>
</nav>
```

#### 2. Preserving Stateful Components

Use `@persist` for elements that should maintain state across navigation:

```blade
{{-- Preserve dropdowns and their event listeners --}}
@persist('navigation-elements')
    <div class="dropdown" x-data="{ open: false }">
        <button @click="open = !open">User Menu</button>
        <div x-show="open" class="dropdown-menu">
            <!-- Dropdown content -->
        </div>
    </div>
@endpersist
```

### JavaScript Re-initialization Patterns

#### The Challenge

Traditional JavaScript that runs on `DOMContentLoaded` only executes on the first page load. With `wire:navigate`, subsequent navigations don't trigger this event.

#### Solution 1: Standard Script with Dual Event Listeners

For complex JavaScript libraries (like SortableJS for drag & drop):

```blade
<script>
function initializeComplexFeature() {
    // Your initialization code here
    console.log('Initializing complex feature...');
    
    // Example: SortableJS initialization
    const containers = document.querySelectorAll('.sortable-container');
    containers.forEach(container => {
        if (!container.sortableInstance) {
            container.sortableInstance = new Sortable(container, {
                group: 'tasks',
                animation: 150,
                onEnd: function(evt) {
                    // Call Livewire methods
                    const componentId = evt.to.getAttribute('data-component-id');
                    if (componentId) {
                        window.Livewire.getByName(componentId)[0].updateTaskPosition(
                            evt.item.getAttribute('data-task-id'),
                            evt.newIndex,
                            evt.to.getAttribute('data-status')
                        );
                    }
                }
            });
        }
    });
}

// Initialize on first load
document.addEventListener('DOMContentLoaded', initializeComplexFeature);

// Re-initialize after wire:navigate
document.addEventListener('livewire:navigated', initializeComplexFeature);
</script>
```

#### Solution 2: Simple @script for Component-Scoped JavaScript

For simple component-specific JavaScript:

```blade
@script
<script>
    Alpine.data('taskForm', () => ({
        priority: 'medium',
        showAdvanced: false,
        
        init() {
            console.log('Task form initialized');
        }
    }));
</script>
@endscript
```

#### Solution 3: Alpine.js Integration

For reactive UI interactions that need to persist across navigation:

```blade
<div x-data="{ 
    activeTab: 'overview',
    sidebarOpen: false 
}" 
x-init="console.log('Alpine component initialized')">
    
    <!-- Alpine automatically handles re-initialization -->
    <button @click="sidebarOpen = !sidebarOpen">Toggle Sidebar</button>
    
</div>
```

### Event System Integration

#### Livewire Navigation Events

```javascript
document.addEventListener('livewire:init', () => {
    // Listen for navigation start
    Livewire.hook('navigate', ({ detail }) => {
        console.log('Navigating to:', detail.url);
        // Show loading indicator
    });
    
    // Listen for navigation complete
    Livewire.hook('navigated', () => {
        console.log('Navigation completed');
        // Hide loading indicator
        // Re-initialize JavaScript if needed
    });
});
```

#### Custom Event Dispatching

```javascript
// In your layout file
<script>
document.addEventListener('livewire:init', () => {
    // Custom event handling
    Livewire.on('close-modal-create', () => {
        document.getElementById('modal-create').style.display = 'none';
    });
    
    Livewire.on('refresh-page-data', () => {
        // Refresh specific page elements
        window.location.reload(); // Or trigger specific component refresh
    });
});
</script>
```

### Common Patterns & Solutions

#### 1. FlyonUI/TallStackUI Dropdown Preservation

```blade
{{-- Wrap dropdown components in @persist --}}
@persist('user-dropdown')
    <div class="dropdown" data-dropdown>
        <button class="dropdown-toggle">User Menu</button>
        <div class="dropdown-menu">
            <a href="{{ route('profile') }}" wire:navigate>Profile</a>
            <a href="{{ route('settings') }}" wire:navigate>Settings</a>
        </div>
    </div>
@endpersist
```

#### 2. Form State Preservation

```blade
{{-- Use Alpine.js for form state that should persist --}}
<form x-data="{ 
    formData: Alpine.$persist({
        search: '',
        filters: {}
    }).as('search-form')
}">
    <input x-model="formData.search" placeholder="Search...">
    <!-- Form persists across navigation -->
</form>
```

#### 3. Third-Party Library Integration

```blade
{{-- For libraries that need DOM manipulation --}}
<div wire:ignore>
    <div id="chart-container"></div>
</div>

<script>
function initializeChart() {
    const container = document.getElementById('chart-container');
    if (container && !container.chartInstance) {
        container.chartInstance = new Chart(container, {
            // Chart configuration
        });
    }
}

document.addEventListener('DOMContentLoaded', initializeChart);
document.addEventListener('livewire:navigated', initializeChart);
</script>
```

### Performance Considerations

#### 1. Asset Optimization

```blade
{{-- In your layout head --}}
<head>
    <!-- These assets are loaded once and cached -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Critical CSS inline for faster first paint -->
    <style>
        .navbar { /* critical navbar styles */ }
        .loading { /* loading spinner styles */ }
    </style>
</head>
```

#### 2. Preloading Strategic Routes

```blade
{{-- Preload commonly visited pages --}}
<a href="{{ route('projects.show', $project) }}" 
   wire:navigate 
   wire:navigate.hover>
    {{ $project->title }}
</a>
```

#### 3. Efficient Component Loading

```php
// Use lazy loading for heavy components
class ProjectDashboard extends Component
{
    public bool $isReady = false;
    
    public function mount()
    {
        // Don't load heavy data immediately
    }
    
    #[On('loadData')]
    public function loadData()
    {
        // Load heavy data only when needed
        $this->isReady = true;
    }
    
    public function render()
    {
        return view('livewire.project.dashboard');
    }
}
```

### Debugging wire:navigate Issues

#### 1. JavaScript Console Monitoring

```javascript
// Add to your layout for debugging
document.addEventListener('livewire:init', () => {
    Livewire.hook('navigate', ({ url }) => {
        console.log('🚀 Navigating to:', url);
    });
    
    Livewire.hook('navigated', () => {
        console.log('✅ Navigation completed');
        console.log('Current page:', window.location.pathname);
    });
    
    // Monitor for broken JavaScript
    window.addEventListener('error', (e) => {
        console.error('JavaScript error after navigation:', e);
    });
});
```

#### 2. Component State Validation

```blade
{{-- Add temporary debug info --}}
@if(config('app.debug'))
    <!-- DEBUG: Component loaded, data ready: {{ $isReady ? 'YES' : 'NO' }} -->
    <!-- DEBUG: User permissions: {{ json_encode(compact('canEdit', 'canDelete')) }} -->
@endif
```

#### 3. Network Monitoring

Use browser developer tools to verify:
- Only XHR requests after first load (no full page refreshes)
- CSS/JS assets served from cache
- Response times improved on subsequent navigations

### Advanced Navigation Features

#### 1. Conditional Navigation

```blade
{{-- Navigate only for authenticated users --}}
<a href="{{ route('dashboard') }}" 
   @if(auth()->check()) wire:navigate @endif>
    Dashboard
</a>

{{-- Skip navigation for external links --}}
@if(str_starts_with($url, config('app.url')))
    <a href="{{ $url }}" wire:navigate>Internal Link</a>
@else
    <a href="{{ $url }}" target="_blank">External Link</a>
@endif
```

#### 2. Navigation Guards

```javascript
document.addEventListener('livewire:init', () => {
    Livewire.hook('navigate', ({ url, navigate }) => {
        // Check if user has unsaved changes
        if (hasUnsavedChanges()) {
            if (!confirm('You have unsaved changes. Continue?')) {
                navigate.prevent();
                return;
            }
        }
        
        // Proceed with navigation
        navigate.go();
    });
});
```

#### 3. Loading States

```blade
{{-- Global loading indicator --}}
<div wire:loading.delay.long class="fixed top-0 left-0 w-full h-1 bg-blue-500 z-50">
    <div class="h-full bg-blue-600 animate-pulse"></div>
</div>

{{-- Page-specific loading --}}
<div x-data="{ loading: false }" 
     @navigate.window="loading = true"
     @navigated.window="loading = false">
     
    <div x-show="loading" class="loading-overlay">
        Navigating...
    </div>
</div>
```

### Migration Strategy

#### 1. Incremental Implementation

```blade
{{-- Start with main navigation --}}
<nav>
    <a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
    <a href="{{ route('projects.index') }}" wire:navigate>Projects</a>
    <!-- Add wire:navigate incrementally -->
</nav>
```

#### 2. Fallback for Complex Pages

```blade
{{-- Skip wire:navigate for pages with complex JavaScript --}}
<a href="{{ route('admin.reports') }}">
    Admin Reports {{-- No wire:navigate for complex admin pages --}}
</a>
```

#### 3. Testing Strategy

1. **Test all navigation paths** with `wire:navigate`
2. **Verify JavaScript initialization** on page transitions  
3. **Check form submissions** work correctly
4. **Validate third-party libraries** still function
5. **Test mobile/responsive behavior**

### Key Takeaways

1. **Start Simple**: Add `wire:navigate` to basic navigation first
2. **Use @persist Strategically**: Only for stateful UI components (dropdowns, etc.)
3. **Dual Event Listeners**: Essential for complex JavaScript libraries
4. **Avoid @script for Complex JS**: Use standard `<script>` tags for libraries like SortableJS
5. **Monitor Performance**: Verify 2-3x speed improvement in practice
6. **Test Thoroughly**: Ensure all JavaScript works across page transitions
7. **Debugging is Key**: Use console logging to track navigation and initialization

### Real-World Benefits Achieved

- **2-3x faster navigation** between pages
- **Seamless user experience** with no page flashes
- **Maintained Laravel simplicity** - no complex SPA configuration
- **Preserved functionality** - all existing features work as before
- **Better perceived performance** - users feel the app is more responsive

The `wire:navigate` implementation transforms your traditional Laravel application into a modern SPA experience while keeping all the benefits of server-side rendering and Laravel's ecosystem.

## 🛡 RBAC Integration & Permission Handling

### Core RBAC Service Implementation

```php
<?php
// app/Services/RBACService.php
namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class RBACService
{
    // Role constants - ALWAYS use IDs, not names
    const ROLE_ADMIN = 1;
    const ROLE_BASIC = 2;
    const ROLE_SUPER_ADMIN = 3;

    /**
     * Context-aware task editing permissions
     * CRITICAL: Context determines permission scope
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
            return $task->assigned_to == $user->id; // Use == for type flexibility
        }

        return false;
    }

    /**
     * Get assignable users based on context and permissions
     */
    public static function getAssignableUsers(?Project $project = null, ?User $user = null, string $context = 'global'): array
    {
        $user = $user ?? Auth::user();
        
        if (self::isSuperAdminOrAdmin($user)) {
            // Super Admin/Admin can assign to anyone in the project (or globally)
            if ($project && $context === 'project') {
                return $project->users()->select('id', 'name')->get()->toArray();
            }
            return User::select('id', 'name')->get()->toArray();
        }

        if (self::isBasic($user)) {
            if ($context === 'global') {
                // My Tasks page - can only assign to themselves
                return [['id' => $user->id, 'name' => $user->name]];
            } else {
                // Project page - cannot create/assign tasks
                return [];
            }
        }

        return [];
    }

    public static function isSuperAdminOrAdmin(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        return $user && $user->hasRole([self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
    }

    public static function isBasic(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        return $user && $user->hasRole([self::ROLE_BASIC]);
    }
}
```

### RBAC-Aware Base Component

```php
<?php
// app/Livewire/Base/RBACTaskComponent.php
namespace App\Livewire\Base;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Traits\RBACHelpers;
use App\Services\RBACService;

abstract class RBACTaskComponent extends Component
{
    use Interactions, RBACHelpers;

    // CRITICAL: Initialize permissions to false
    public $canEdit = false;
    public $canDelete = false;
    public $canCreate = false;
    public $isViewOnly = true;

    // Context is crucial for proper permissions
    public $context = 'global'; // 'global' for My Tasks, 'project' for project pages

    public function mount()
    {
        $this->initializeRBAC();
        $this->bootComponent();
    }

    protected function bootComponent()
    {
        // Override in child components
    }

    /**
     * CRITICAL: Load task with proper permission checking
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

        // Set permissions BEFORE rendering
        $this->setTaskPermissions($task);
        
        return $task;
    }

    /**
     * Format users for select components with type safety
     */
    protected function loadAssignableUsers($project = null, $currentAssignedId = null)
    {
        $users = RBACService::getAssignableUsers($project, null, $this->context);
        return $this->getFormattedUsers($users, $currentAssignedId);
    }
}
```

### Context-Aware TaskEdit Component

```php
<?php
// app/Livewire/Project/TaskEdit.php - RBAC Version
namespace App\Livewire\Project;

use App\Livewire\Base\RBACTaskComponent;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Services\RBACService;
use Livewire\Attributes\On;

class TaskEdit extends RBACTaskComponent
{
    public $taskId;
    public $title, $description, $project_id, $assigned_to;
    public $projects, $users, $statuses, $taskTypes, $priorities;

    protected $rules = Task::TASK_UPDATE_RULES;

    #[On('loadTask')]
    public function loadData($taskId, $context = 'global')
    {
        $this->taskId = $taskId;
        $this->context = $context;

        $task = Task::with(['assignee', 'project'])->findOrFail($taskId);

        // CRITICAL: Set permissions BEFORE populating form
        $this->setTaskPermissions($task);

        if (!RBACService::canViewTask($task)) {
            $this->toast()->error('Error', 'No permission to view task')->send();
            $this->dispatch('close-modal-edit');
            return;
        }

        // Populate form fields
        $this->title = $task->title;
        $this->project_id = $task->project_id;
        $this->assigned_to = (string)$task->assigned_to; // CRITICAL: Cast to string for TallStackUI
        $this->description = $task->description;

        // Load users with assigned user always included
        $this->users = $this->loadAssignableUsers($task->project, $task->assigned_to);
        
        $this->dispatch('open-modal-edit');
    }

    public function update()
    {
        $task = Task::findOrFail($this->taskId);
        
        if (!RBACService::canEditTask($task)) {
            $this->toast()->error('Error', 'No permission to edit this task')->send();
            return;
        }

        $validated = $this->validate();
        $task->update($validated);

        $this->dispatch('close-modal-edit');
        $this->dispatch('loadData-tasks');
        $this->toast()->success('Updated', 'Task updated successfully')->send();
    }
}
```

### Critical Blade Template Pattern

```blade
{{-- resources/views/livewire/project/task-edit.blade.php --}}
<div>
    <x-errors class="mb-4" />

    {{-- CRITICAL: Only render form after task is loaded and permissions set --}}
    @if($taskId)
        <form id="form-edit" wire:submit.prevent="update">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input 
                    label="Title *" 
                    wire:model.defer="title" 
                    required 
                    :disabled="!$canEdit" 
                />

                <x-select.styled
                    label="Assign To *"
                    wire:model.defer="assigned_to"
                    :options="collect($users ?? [])->map(fn($u) => ['name' => $u['name'], 'id' => (string)$u['id']])->toArray()"
                    select="label:name|value:id"
                    placeholder="Select user"
                    :disabled="!$canEdit"
                />
                
                {{-- More form fields... --}}
            </div>

            <div class="text-right mt-6">
                <x-button 
                    x-on:click="$dispatch('close-modal-edit')"
                    class="border">
                    {{ $isViewOnly ? 'Close' : 'Cancel' }}
                </x-button>
                
                @if(!$isViewOnly)
                    <x-button type="submit" color="green" loading>
                        Update Task
                    </x-button>
                @endif
            </div>
        </form>
    @else
        <div class="text-center py-4">
            <p>Loading task...</p>
        </div>
    @endif
</div>
```

### Event Dispatching with Context

```blade
{{-- CRITICAL: Always pass context in dispatches --}}

{{-- From project pages (task-board.blade.php, task-list.blade.php) --}}
wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })"

{{-- From My Tasks page (context defaults to 'global') --}}
wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: 'global' })"
```

---

### Step 1: Create the Model

```php
<?php
// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'assigned_to', 'title', 'description', 
        'priority', 'status', 'due_date', 'created_by', 'task_type_id'
    ];

    // Validation rules for Livewire components
    public const TASK_CREATE_RULES = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'project_id' => 'required|exists:projects,id',
        'assigned_to' => 'required|exists:users,id',
        'status' => 'required|in:1,2,3,4,5',
        'due_date' => 'nullable|date',
        'task_type_id' => 'required|exists:task_types,id',
        'priority' => 'required|exists:priorities,name',
    ];

    public const TASK_CREATE_MESSAGES = [
        'project_id.exists' => 'The selected project is invalid.',
        'assigned_to.exists' => 'The selected user is invalid.',
        'priority.in' => 'Priority must be Low, Medium, or High.',
        'status.in' => 'The selected status is invalid.',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
```

### Step 2: Set Up Database Migration

```php
<?php
// database/migrations/create_tasks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('priority');
            $table->tinyInteger('status')->default(1);
            $table->date('due_date')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('task_type_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
```

---

## 🔧 Creating Components (CRUD Operations)

### 🔍 READ: Display/List Component (`TaskShow.php`)

```php
<?php
// app/Livewire/Project/TaskShow.php
namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class TaskShow extends Component
{
    use WithPagination;

    public bool $isReady = false;
    public ?string $search = null;
    public ?int $quantity = 10;
    public array $selected = [];
    public array $sort = ['column' => 'id', 'direction' => 'asc'];

    // 🎯 Event listener to load data
    #[On('loadData-tasks')]
    public function loadData()
    {
        $this->isReady = true;
    }

    // 📊 Table headers configuration
    public function headers(): array
    {
        return [
            ['index' => 'id', 'label' => '#', 'sortable' => true],
            ['index' => 'title', 'label' => 'Task', 'sortable' => true],
            ['index' => 'priority', 'label' => 'Priority', 'sortable' => true],
            ['index' => 'status_label', 'label' => 'Status', 'sortable' => false],
            ['index' => 'due_date', 'label' => 'Due Date', 'sortable' => true],
            ['index' => 'action', 'label' => 'Actions', 'sortable' => false],
        ];
    }

    // 🗂 Data retrieval with relationships
    public function rows()
    {
        if (!$this->isReady) {
            return collect();
        }

        return Task::with(['project', 'assignee', 'taskType'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    // 🔄 Sorting functionality
    public function sortBy($column)
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] = $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.project.task-show');
    }
}
```

**📋 Corresponding Blade Template** (`task-show.blade.php`):

```blade
{{-- resources/views/livewire/project/task-show.blade.php --}}
<div wire:init="loadData">
    {{-- 🎭 Alpine.js reactive data --}}
    <div x-data="{ selectedTaskId: null }">
        
        {{-- 🗑 Include delete component --}}
        <livewire:project.task-delete />
        
        {{-- ✏️ Edit Modal --}}
        <x-modal id="modal-update" center>
            <h2 class="text-lg font-semibold text-gray-700">Edit Task</h2>
            <livewire:project.task-edit />
        </x-modal>
        
        {{-- ➕ Create Modal --}}
        <x-modal id="modal-create" center>
            <h2 class="text-lg font-semibold text-gray-700">Create Task</h2>
            <livewire:project.task-create />
        </x-modal>

        {{-- 📊 Data Table --}}
        <x-table
            :headers="$this->headers()"
            :rows="$this->rows()"
            striped
            filter
            paginate
            loading
        >
            {{-- 🎬 Custom action column --}}
            @interact('column_action', $row)
                <div class="flex gap-2">
                    <x-button.circle
                        icon="pencil-square"
                        color="indigo"
                        size="sm"
                        x-on:click="$modalOpen('modal-update')"
                        wire:click="$dispatch('loadTask', { taskId: {{ $row['id'] }} })"
                    />
                    <x-button.circle
                        icon="trash"
                        color="red"
                        size="sm"
                        wire:click="$dispatch('delete-task', { taskId: {{ $row['id'] }} })"
                    />
                </div>
            @endinteract
        </x-table>

        {{-- ➕ Add new task button --}}
        <div class="mt-4">
            <x-button
                color="green"
                icon="plus"
                x-on:click="$modalOpen('modal-create')"
            >
                Add New Task
            </x-button>
        </div>
    </div>
</div>
```

### ➕ CREATE: Add New Records (`TaskCreate.php`)

```php
<?php
// app/Livewire/Project/TaskCreate.php
namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Priority;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class TaskCreate extends Component
{
    use Interactions; // 🎉 Provides toast notifications

    // 📝 Form properties
    public $title, $description, $project_id, $assigned_to;
    public $priority, $status, $due_date, $task_type_id;
    
    // 📊 Dropdown data
    public $projects, $users, $statuses, $taskTypes, $priorities;

    // ✅ Validation rules from model
    protected $rules = Task::TASK_CREATE_RULES;
    protected $messages = Task::TASK_CREATE_MESSAGES;

    // 🚀 Initialize dropdown data
    public function mount()
    {
        $this->projects = Project::select('id', 'title')->get();
        $this->users = User::select('id', 'name')->get();
        $this->statuses = TaskStatus::select('id', 'name')->get();
        $this->taskTypes = TaskType::where('is_active', true)->get();
        $this->priorities = Priority::select('name')->get();
    }

    // 🔄 Real-time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // 💾 Create new task
    public function register()
    {
        $validated = $this->validate();
        $validated['created_by'] = auth()->id();
        $validated['title'] = ucfirst($validated['title']);

        Task::create($validated);

        // 🎯 Dispatch events
        $this->dispatch('close-modal-create');
        $this->dispatch('loadData-tasks'); // Refresh list
        
        // 🎉 Success notification
        $this->toast()->success('Success', 'Task created successfully')->send();
        
        // 🧹 Reset form
        $this->reset();
    }

    public function render()
    {
        return view('livewire.project.task-create');
    }
}
```

**📋 Create Form Template** (`task-create.blade.php`):

```blade
{{-- resources/views/livewire/project/task-create.blade.php --}}
<div>
    {{-- 🚨 Error display --}}
    <x-errors />
    
    <form wire:submit.prevent="register">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- 📝 Basic inputs --}}
            <x-input 
                label="Title *" 
                wire:model.defer="title" 
                required 
            />

            {{-- 📋 Dropdown selects --}}
            <x-select.styled
                label="Project *"
                wire:model.defer="project_id"
                :options="$projects->map(fn($p) => ['name' => $p->title, 'id' => $p->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select project"
            />

            <x-select.styled
                label="Assign To *"
                wire:model.defer="assigned_to"
                :options="$users->map(fn($u) => ['name' => $u->name, 'id' => $u->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select user"
            />

            <x-select.styled
                label="Priority *"
                wire:model.defer="priority"
                :options="$priorities->map(fn($p) => ['name' => ucfirst($p->name), 'id' => $p->name])->toArray()"
                select="label:name|value:id"
                placeholder="Select priority"
            />

            <x-select.styled
                label="Status *"
                wire:model.defer="status"
                :options="$statuses->map(fn($s) => ['name' => $s->name, 'id' => $s->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select status"
            />

            <x-select.styled
                label="Task Type *"
                wire:model.defer="task_type_id"
                :options="$taskTypes->map(fn($t) => ['name' => $t->name, 'id' => $t->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select task type"
            />

            {{-- 📅 Date picker --}}
            <x-date 
                label="Due Date" 
                wire:model.defer="due_date" 
            />
        </div>

        {{-- 📝 Textarea --}}
        <x-textarea
            label="Description"
            wire:model.defer="description"
            class="mt-4"
            rows="4"
        />

        {{-- ✅ Submit button --}}
        <div class="text-right mt-6">
            <x-button type="submit" color="green" loading>
                Create Task
            </x-button>
        </div>
    </form>
</div>
```

### ✏️ UPDATE: Edit Records (`TaskEdit.php`)

```php
<?php
// app/Livewire/Project/TaskEdit.php
namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Priority;
use App\Models\Comment;
use App\Models\Doc;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;

class TaskEdit extends Component
{
    use Interactions, WithFileUploads;

    // 🆔 Task identifier
    public $taskId;
    
    // 📝 Form properties
    public $title, $project_id, $assigned_to, $priority;
    public $status, $due_date, $description, $task_type_id;
    
    // 📊 Dropdown data
    public $projects, $users, $statuses, $taskTypes, $priorities;
    
    // 📎 File handling
    public $attachment;
    public $attachments = [];
    
    // 💬 Comments system
    public $comments = [];
    public $commentText = '';
    public $editingCommentId = null;

    protected $rules = Task::TASK_CREATE_RULES;
    protected $messages = Task::TASK_CREATE_MESSAGES;

    // 🎯 Load task data for editing
    #[On('loadTask')]
    public function loadData($taskId)
    {
        $this->taskId = $taskId;
        
        $task = Task::with(['comments.user', 'docs'])->findOrFail($taskId);
        
        // 📝 Populate form fields
        $this->title = $task->title;
        $this->project_id = $task->project_id;
        $this->assigned_to = $task->assigned_to;
        $this->priority = $task->priority;
        $this->status = $task->status;
        $this->due_date = $task->due_date;
        $this->description = $task->description;
        $this->task_type_id = $task->task_type_id;
        
        // 📊 Load dropdown options
        $this->projects = Project::select('id', 'title')->get();
        $this->users = User::select('id', 'name')->get();
        $this->statuses = TaskStatus::select('id', 'name')->get();
        $this->priorities = Priority::select('name')->get();
        $this->taskTypes = TaskType::select('id', 'name')->where('is_active', 1)->get();
        
        // 💬 Load related data
        $this->loadComments();
        $this->attachments = $task->docs;
        
        $this->dispatch('open-modal-edit');
    }

    // 💾 Update task
    public function update()
    {
        $data = $this->validate();
        
        Task::findOrFail($this->taskId)->update($data);
        
        $this->dispatch('close-modal-edit');
        $this->dispatch('loadData-tasks');
        $this->toast()->success('Updated', 'Task updated successfully')->send();
    }

    // 📎 Handle file attachments
    public function saveAttachment()
    {
        $this->validate([
            'attachment' => 'required|file|max:5120', // 5MB max
        ]);

        $path = $this->attachment->store('attachments', 'public');
        
        Doc::create([
            'name' => $this->attachment->getClientOriginalName(),
            'path' => $path,
            'type' => $this->attachment->getClientMimeType(),
            'task_id' => $this->taskId,
            'project_id' => $this->project_id,
            'uploaded_by' => auth()->id(),
        ]);

        $this->attachment = null;
        $this->loadAttachments();
        $this->toast()->success('Uploaded', 'Attachment saved successfully')->send();
    }

    // 🗑 Delete attachment
    public function deleteAttachment($id)
    {
        $file = Doc::findOrFail($id);
        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }
        $file->delete();
        $this->loadAttachments();
    }

    // 💬 Comments functionality
    public function saveComment()
    {
        $this->validate([
            'commentText' => 'required|string|max:1000',
        ]);

        if ($this->editingCommentId) {
            // Update existing comment
            Comment::where('id', $this->editingCommentId)->update([
                'content' => $this->commentText,
            ]);
        } else {
            // Create new comment
            Comment::create([
                'content' => $this->commentText,
                'user_id' => auth()->id(),
                'task_id' => $this->taskId,
            ]);
        }

        $this->commentText = '';
        $this->editingCommentId = null;
        $this->loadComments();
    }

    public function editComment($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $this->editingCommentId = $id;
            $this->commentText = $comment->content;
        }
    }

    public function deleteComment($id)
    {
        Comment::where('id', $id)->delete();
        $this->loadComments();
    }

    private function loadComments()
    {
        $this->comments = Comment::with('user')
            ->where('task_id', $this->taskId)
            ->latest()
            ->get();
    }

    private function loadAttachments()
    {
        $this->attachments = Doc::where('task_id', $this->taskId)->latest()->get();
    }

    public function render()
    {
        return view('livewire.project.task-edit');
    }
}
```

**📋 Edit Form Template** (`task-edit.blade.php`):

```blade
{{-- resources/views/livewire/project/task-edit.blade.php --}}
<div class="max-w-screen-2xl w-full mx-auto px-6 py-6">
    <x-errors />

    <form wire:submit.prevent="update" class="flex flex-col lg:flex-row gap-6">
        {{-- 📝 Main form section --}}
        <div class="w-full lg:w-1/2 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Form fields identical to create form --}}
                <x-input label="Title *" wire:model.defer="title" required />
                
                <x-select.styled
                    label="Project *"
                    wire:model.defer="project_id"
                    :options="$projects?->map(fn($p) => ['name' => $p->title, 'id' => $p->id])->toArray() ?? []"
                    select="label:name|value:id"
                    placeholder="Select project"
                />
                
                {{-- Additional form fields... --}}
            </div>

            <x-textarea 
                resize-auto 
                label="Description" 
                wire:model.defer="description" 
                class="mt-4" 
            />

            {{-- 📎 Attachments section --}}
            <x-card class="shadow-sm">
                <x-slot name="header">
                    <h2 class="text-lg font-semibold">Attachments</h2>
                </x-slot>

                <x-upload
                    wire:model="attachment"
                    delete
                    label="Upload File"
                    color="blue"
                    class="mb-4"
                >
                    <x-slot:footer>
                        <x-button wire:click="saveAttachment" color="green" class="w-full">
                            Save
                        </x-button>
                    </x-slot:footer>
                </x-upload>

                {{-- 📋 Existing attachments --}}
                <div class="space-y-2">
                    @foreach ($attachments as $file)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <span class="text-sm">{{ $file->name }}</span>
                            <x-button wire:click="deleteAttachment({{ $file->id }})" color="red" size="sm">
                                Delete
                            </x-button>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        {{-- 💬 Comments section --}}
        <div class="w-full lg:w-1/2 space-y-6">
            <x-card class="h-full flex flex-col shadow-sm">
                <x-slot name="header">
                    <h2 class="text-lg font-semibold">Comments</h2>
                </x-slot>
                
                <x-textarea 
                    resize-auto 
                    wire:model.defer="commentText" 
                    label="Add Comment" 
                />

                <x-button wire:click="saveComment" class="mt-2" color="blue" size="sm">
                    {{ $editingCommentId ? 'Update Comment' : 'Add Comment' }}
                </x-button>

                {{-- 💬 Comments list --}}
                <ul class="mt-4 space-y-2 overflow-y-auto max-h-[400px]">
                    @forelse ($comments as $comment)
                        <li class="text-sm p-2 rounded hover:bg-gray-50 transition cursor-pointer group" 
                            wire:key="comment-{{ $comment->id }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <strong>{{ $comment->user->name ?? 'Unknown' }}</strong>: {{ $comment->content }}
                                    <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                    
                                    {{-- ✏️ Edit/Delete buttons (shown on hover) --}}
                                    <div class="text-xs text-blue-500 space-x-2 hidden group-hover:flex">
                                        <a wire:click="editComment({{ $comment->id }})" 
                                           type="button" class="hover:underline">Edit</a>
                                        <a wire:click="deleteComment({{ $comment->id }})" 
                                           type="button" class="hover:underline">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">No comments yet.</li>
                    @endforelse
                </ul>
            </x-card>
        </div>
    </form>

    {{-- ✅ Update button --}}
    <div class="w-full flex justify-end mt-6">
        <x-button type="submit" color="green" loading form="form-edit">
            Update Task
        </x-button>
    </div>
</div>
```

### 🗑 DELETE: Remove Records (`TaskDelete.php`)

```php
<?php
// app/Livewire/Project/TaskDelete.php
namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class TaskDelete extends Component
{
    use Interactions;

    public $taskId;

    // 🎯 Listen for delete event
    #[On('delete-task')]
    public function openDeleteDialog($taskId)
    {
        $this->taskId = $taskId;

        // 🚨 Show confirmation dialog
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this task?')
            ->confirm('Confirm', 'confirmed', $taskId)
            ->cancel('Cancel')
            ->send();
    }

    // 💥 Execute deletion
    public function confirmed($taskId): void
    {
        $task = Task::findOrFail($taskId);
        $taskTitle = $task->title;

        $task->delete();
        $this->taskId = null;

        // 📝 Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_task',
            'description' => 'Deleted task: ' . $taskTitle,
            'ip_address' => request()->ip(),
        ]);

        // 🎉 Success notification
        $this->toast()->success('Deleted', "Task '{$taskTitle}' deleted successfully")->send();

        // 🔄 Refresh data
        $this->dispatch('loadData-tasks');
    }

    public function render()
    {
        return view('livewire.project.task-delete');
    }
}
```

**📋 Delete Component Template** (`task-delete.blade.php`):

```blade
{{-- resources/views/livewire/project/task-delete.blade.php --}}
<div>
    {{-- This component handles deletion via dialog interactions --}}
    {{-- No visible UI needed - works through TallStackUI dialog system --}}
</div>
```

---

## 🎨 Frontend Integration

### Alpine.js Integration Patterns

#### 1. Modal Control
```javascript
// Opening modals with Alpine.js
x-on:click="$modalOpen('modal-create')"

// Closing modals via Livewire events
Livewire.on('close-modal-create', () => {
    $modalClose('modal-create');
});
```

#### 2. Reactive Data
```blade
<div x-data="{ 
    selectedItems: [], 
    showFilters: false,
    activeTab: 'todo'
}">
    <!-- Alpine reactive content -->
</div>
```

#### 3. Event Handling
```blade
{{-- Alpine to Livewire --}}
<button x-on:click="$wire.someMethod()">Click me</button>

{{-- Livewire to Alpine --}}
<div wire:click="$dispatch('alpine-event', { data: 'value' })">
```

### TallStackUI Component Usage

#### Form Components
```blade
{{-- Input fields --}}
<x-input label="Title" wire:model.defer="title" />

{{-- Select dropdowns --}}
<x-select.styled
    label="Status"
    wire:model.defer="status"
    :options="$options"
    select="label:name|value:id"
/>

{{-- Date picker --}}
<x-date label="Due Date" wire:model.defer="due_date" />

{{-- File upload --}}
<x-upload wire:model="file" label="Upload Document" />

{{-- Textarea --}}
<x-textarea label="Description" wire:model.defer="description" />
```

#### UI Components
```blade
{{-- Buttons --}}
<x-button color="green" loading>Save</x-button>
<x-button.circle icon="edit" color="blue" />

{{-- Cards --}}
<x-card class="shadow-sm">
    <x-slot name="header">Header Content</x-slot>
    Card body content
</x-card>

{{-- Tables --}}
<x-table :headers="$headers" :rows="$rows" striped paginate />

{{-- Modals --}}
<x-modal id="modal-create" center>
    Modal content
</x-modal>
```

---

## 📡 Component Communication

### Event System

#### Dispatching Events
```php
// From Livewire component
$this->dispatch('event-name', ['key' => 'value']);

// To specific component
$this->dispatch('event-name')->to('component-name');

// To all components
$this->dispatch('event-name')->self();
```

#### Listening to Events
```php
// Using attributes
#[On('event-name')]
public function handleEvent($data)
{
    // Handle event
}

// Using protected $listeners (older approach)
protected $listeners = [
    'event-name' => 'handleEvent',
];
```

#### Frontend Event Listeners
```javascript
// In your layout file
<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('close-modal-create', () => {
        $modalClose('modal-create');
    });
    
    Livewire.on('refresh-data', (data) => {
        // Handle data refresh
        console.log('Data refreshed:', data);
    });
});
</script>
```

### Common Event Patterns

```php
// Loading data
$this->dispatch('loadData-tasks');

// CRUD operations
$this->dispatch('create-task', ['task' => $task]);
$this->dispatch('edit-task', ['taskId' => $id]);
$this->dispatch('delete-task', ['taskId' => $id]);

// UI interactions
$this->dispatch('close-modal-create');
$this->dispatch('open-modal-edit');

// Notifications
$this->toast()->success('Success', 'Operation completed')->send();
$this->toast()->error('Error', 'Operation failed')->send();
```

---

## 🚀 Advanced Features

### File Upload Handling

```php
use Livewire\WithFileUploads;

class TaskEdit extends Component
{
    use WithFileUploads;
    
    public $attachment;
    
    public function saveAttachment()
    {
        $this->validate([
            'attachment' => 'required|file|max:5120', // 5MB
        ]);
        
        $path = $this->attachment->store('attachments', 'public');
        
        // Save to database
        Doc::create([
            'name' => $this->attachment->getClientOriginalName(),
            'path' => $path,
            'task_id' => $this->taskId,
        ]);
        
        $this->attachment = null;
        $this->toast()->success('Uploaded', 'File saved successfully')->send();
    }
}
```

### Real-time Validation

```php
public function updated($propertyName)
{
    // Validate individual field as user types
    $this->validateOnly($propertyName);
    
    // Custom validation logic
    if ($propertyName === 'email') {
        $this->validateEmail();
    }
}

private function validateEmail()
{
    if (User::where('email', $this->email)->exists()) {
        $this->addError('email', 'Email already exists.');
    }
}
```

### Pagination with Search

```php
use Livewire\WithPagination;

class TaskShow extends Component
{
    use WithPagination;
    
    public $search = '';
    public $quantity = 10;
    
    public function updatedSearch()
    {
        $this->resetPage(); // Reset to page 1 when searching
    }
    
    public function rows()
    {
        return Task::query()
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->quantity);
    }
}
```

### Loading States

```blade
{{-- Show loading during specific actions --}}
<div wire:loading wire:target="saveTask">
    Saving task...
</div>

{{-- Loading overlay --}}
<div wire:loading.delay class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50">
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-4 rounded-lg">Loading...</div>
    </div>
</div>

{{-- Conditional loading --}}
<div wire:loading.remove>
    <!-- Content shown when not loading -->
</div>

<div wire:loading>
    <!-- Content shown when loading -->
</div>
```

---

## 📝 Best Practices

### 1. Component Organization
- **Single Responsibility**: Each component handles one specific action (Create, Read, Update, Delete)
- **Consistent Naming**: Follow the `FeatureAction.php` pattern
- **Logical Grouping**: Group related components in directories

### 2. Data Handling
- **Use Defer**: `wire:model.defer` for better performance on forms
- **Validation**: Always validate data using model constants
- **Real-time Updates**: Implement real-time validation for better UX

### 3. Event Management
- **Descriptive Names**: Use clear, descriptive event names
- **Consistent Patterns**: Follow established event naming conventions
- **Proper Cleanup**: Reset component state after operations

### 4. Security
- **Authorization**: Always check user permissions
- **CSRF Protection**: Include `@csrf` in forms
- **Input Sanitization**: Validate and sanitize all inputs

### 5. Performance
- **Lazy Loading**: Use `wire:init` for delayed data loading
- **Efficient Queries**: Use `with()` to prevent N+1 queries
- **Pagination**: Implement pagination for large datasets

### 6. UI/UX
- **Loading States**: Show loading indicators for async operations
- **Error Handling**: Display clear error messages
- **Success Feedback**: Provide success notifications
- **Responsive Design**: Ensure components work on all devices

---

## 🔄 Common Patterns

### Modal-Based CRUD
```blade
{{-- Main component with modals --}}
<div x-data="{ selectedId: null }">
    <!-- List/Show component -->
    <livewire:feature.feature-show />
    
    <!-- Create Modal -->
    <x-modal id="modal-create">
        <livewire:feature.feature-create />
    </x-modal>
    
    <!-- Edit Modal -->
    <x-modal id="modal-edit">
        <livewire:feature.feature-edit />
    </x-modal>
    
    <!-- Delete component (no UI) -->
    <livewire:feature.feature-delete />
</div>
```

### Data Refresh Pattern
```php
// After any CRUD operation
public function afterCrudOperation()
{
    $this->dispatch('loadData-features'); // Refresh main list
    $this->dispatch('close-modal-create'); // Close modal
    $this->toast()->success('Success', 'Operation completed')->send();
    $this->reset(); // Clear form data
}
```

### Search and Filter Pattern
```php
public $search = '';
public $filters = [
    'status' => '',
    'priority' => '',
    'date_from' => '',
    'date_to' => '',
];

public function applyFilters($query)
{
    return $query
        ->when($this->search, fn($q) => 
            $q->where('title', 'like', '%'.$this->search.'%')
        )
        ->when($this->filters['status'], fn($q) => 
            $q->where('status', $this->filters['status'])
        )
        ->when($this->filters['priority'], fn($q) => 
            $q->where('priority', $this->filters['priority'])
        );
}
```

---

## 🐛 Troubleshooting

### wire:navigate Issues

#### 1. JavaScript Not Working After Navigation
```javascript
// Problem: JavaScript only works on first page load
// Solution: Use dual event listeners

// ❌ WRONG: Only listens to initial load
document.addEventListener('DOMContentLoaded', initializeFeature);

// ✅ CORRECT: Works for both initial load and navigation
document.addEventListener('DOMContentLoaded', initializeFeature);
document.addEventListener('livewire:navigated', initializeFeature);
```

#### 2. Alpine.js "Unexpected token" Errors
```blade
{{-- Problem: @script conflicts with Alpine.js for complex JavaScript --}}
{{-- ❌ WRONG: Alpine tries to parse complex JS as Alpine expressions --}}
@script
<script>
const sortable = new Sortable(container, { /* complex config */ });
</script>
@endscript

{{-- ✅ CORRECT: Use standard script tag for complex libraries --}}
<script>
function initializeSortable() {
    const sortable = new Sortable(container, { /* complex config */ });
}
document.addEventListener('DOMContentLoaded', initializeSortable);
document.addEventListener('livewire:navigated', initializeSortable);
</script>
```

#### 3. Dropdowns/UI Components Breaking
```blade
{{-- Problem: Event listeners lost after navigation --}}
{{-- Solution: Use @persist for stateful components --}}

{{-- ✅ CORRECT: Preserve dropdown state and events --}}
@persist('navigation-dropdowns')
    <div class="dropdown" data-dropdown>
        <button class="dropdown-toggle">Menu</button>
        <div class="dropdown-menu">
            <!-- Dropdown content -->
        </div>
    </div>
@endpersist
```

#### 4. Third-Party Library Re-initialization
```blade
{{-- For libraries that modify the DOM --}}
<div wire:ignore>
    <div id="chart-container"></div>
</div>

<script>
function initializeChart() {
    const container = document.getElementById('chart-container');
    
    // Prevent double initialization
    if (container && !container.hasChartInstance) {
        container.chartInstance = new Chart(container, config);
        container.hasChartInstance = true;
    }
}

// Dual initialization pattern
document.addEventListener('DOMContentLoaded', initializeChart);
document.addEventListener('livewire:navigated', initializeChart);
</script>
```

#### 5. Performance Not Improved
Check these common issues:
- Links missing `wire:navigate` attribute
- External links using `wire:navigate` (should only be internal)
- Heavy JavaScript running on every navigation
- Assets not properly cached

```javascript
// Debug navigation performance
document.addEventListener('livewire:init', () => {
    const startTime = performance.now();
    
    Livewire.hook('navigate', () => {
        console.log('🚀 Navigation started');
    });
    
    Livewire.hook('navigated', () => {
        const endTime = performance.now();
        console.log(`✅ Navigation completed in ${endTime - startTime}ms`);
    });
});
```

### RBAC & Permission Issues

#### 1. Form Fields Appear Disabled When They Should Be Enabled
```php
// Root Cause: Component renders before permissions are set
// Solution: Use conditional rendering in Blade
@if($taskId) {{-- Only render after data loaded --}}
    <form>...</form>
@else
    <div>Loading...</div>
@endif
```

#### 2. Assigned User Not Showing in Select Dropdown  
```php
// Root Cause: Assigned user not included in options list
// Solution: Always include assigned user first
$this->users = $this->getFormattedUsers($assignableUsers, $task->assigned_to);
```

#### 3. Select Components Not Working with Mixed Data Types
```php
// Root Cause: TallStackUI expects consistent string types
// Solution: Cast all IDs to strings
'id' => (string)$user->id // ✅ Always cast to string
```

#### 4. Role Checking Returns False When It Should Be True
```php
// Root Cause: hasRole() expects IDs but receives names
// Solution: Use role ID constants
const ROLE_ADMIN = 1; // ✅ Use IDs, not names
$user->hasRole([self::ROLE_ADMIN]); // ✅ Pass IDs
```

#### 5. Context Not Working Properly
```php
// Root Cause: Context not passed in dispatch events
// Solution: Always include context
wire:click="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })"
```

### Common Livewire Issues

#### 1. Events Not Firing
```php
// Problem: Event listeners not working
#[On('my-event')] // ✅ Correct
public function handleEvent() { }

// Instead of:
protected $listeners = ['my-event']; // ❌ Old approach
```

#### 2. Form Not Submitting
```blade
{{-- Ensure proper form binding --}}
<form wire:submit.prevent="save"> {{-- ✅ Correct --}}
<form wire:submit="save"> {{-- ❌ Missing prevent --}}
```

#### 3. File Upload Issues
```php
// Add WithFileUploads trait
use Livewire\WithFileUploads;

class MyComponent extends Component
{
    use WithFileUploads; // ✅ Don't forget this
    
    public $file;
}
```

#### 4. Validation Not Working
```php
// Define rules properly
protected $rules = [
    'title' => 'required|string|max:255', // ✅ Correct
];

// Not like this:
protected $rules = 'required|string'; // ❌ Wrong format
```

#### 5. Modal Not Opening
```javascript
// Ensure TallStackUI is properly configured
x-on:click="$modalOpen('modal-id')" // ✅ Correct

// Check for typos:
x-on:click="$modalopen('modal-id')" // ❌ Case sensitive
```

### Debugging Strategies That Actually Work

#### 1. Isolate the Problem
```php
// Create standalone test files for complex logic
// Test RBAC separately from UI components
// Use simple echo/var_dump to verify data

// Example: test_rbac.php
$user = User::find(2);
$task = Task::find(4);
echo "Can edit: " . (RBACService::canEditTask($task, $user) ? 'YES' : 'NO');
```

#### 2. Add Temporary Debug Comments
```blade
<!-- DEBUG: canEdit={{ $canEdit ? 'true' : 'false' }}, userID={{ auth()->id() }} -->
<x-input :disabled="!$canEdit" />
```

#### 3. Use Browser Developer Tools
- **Network Tab**: Check AJAX requests for Livewire updates
- **Console**: Look for JavaScript errors
- **Elements**: Inspect actual disabled/enabled states

#### 4. Laravel Debugging
```php
// Temporary debug logging
\Log::info('Debug', [
    'component' => 'TaskEdit',
    'canEdit' => $this->canEdit,
    'taskId' => $this->taskId,
    'userId' => auth()->id()
]);

// Check storage/logs/laravel.log
```

### Prevention Checklist

Before deploying RBAC components:

- [ ] ✅ All form fields use conditional rendering `@if($dataLoaded)`
- [ ] ✅ All IDs cast to strings for select components  
- [ ] ✅ Context passed in all loadTask dispatches
- [ ] ✅ Assigned users always included in dropdowns
- [ ] ✅ Permission checks use proper role ID constants
- [ ] ✅ Component properties initialized to safe defaults
- [ ] ✅ Event naming follows established conventions
- [ ] ✅ RBAC logic tested independently from UI

## 🚨 Critical Best Practices & Lessons Learned

### 1. Component Initialization & Rendering Order

**THE MAIN ROOT CAUSE OF MOST ISSUES:**

```php
// ❌ WRONG: Form renders with default false values
public $canEdit = false; // Component loads...
// Meanwhile, Blade template renders with canEdit=false
// User sees disabled form

// Later...
#[On('loadTask')]
public function loadData($taskId) {
    $this->canEdit = true; // Too late! Form already rendered
}
```

**✅ SOLUTION: Guard Against Premature Rendering**

```blade
{{-- CRITICAL: Only render form after data is loaded --}}
@if($taskId) {{-- or whatever indicates data is ready --}}
    <form>
        {{-- Form fields with proper :disabled="!$canEdit" --}}
    </form>
@else
    <div class="text-center py-4">Loading...</div>
@endif
```

### 2. Data Type Consistency for TallStackUI

**CRITICAL for select components:**

```php
// ❌ WRONG: Mixed integer/string types break TallStackUI
$this->assigned_to = $task->assigned_to; // Integer from DB
$this->users = User::select('id', 'name')->get(); // IDs are integers

// ✅ CORRECT: Always cast to strings
$this->assigned_to = (string)$task->assigned_to;
$this->users = $users->map(fn($u) => [
    'id' => (string)$u->id,    // CRITICAL: Cast to string
    'name' => $u->name
])->toArray();
```

### 3. Context-Aware Permission System

```php
// Context determines permission scope:
// 'global' = My Tasks page (basic users can only see/edit own tasks)  
// 'project' = Project pages (role-based permissions within project)

public function loadData($taskId, $context = 'global') {
    $this->context = $context; // CRITICAL: Set context first
    
    // Permissions depend on context
    $this->canEdit = RBACService::canEditTask($task, null, $this->context);
}
```

### 4. Always Include Assigned User in Select Options

```php
// ❌ WRONG: Assigned user might not appear in dropdown
$this->users = RBACService::getAssignableUsers($project);

// ✅ CORRECT: Always include assigned user first
public function getFormattedUsers($users, $assignedUserId = null) {
    $formattedUsers = [];
    
    // ALWAYS include assigned user first
    if ($assignedUserId) {
        $assignedUser = User::find($assignedUserId);
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
        if (!collect($formattedUsers)->contains('id', $userId)) {
            $formattedUsers[] = ['id' => $userId, 'name' => $user['name'] ?? $user->name];
        }
    }
    
    return $formattedUsers;
}
```

### 5. Role Checking with Proper Data Types

```php
// User model hasRole method expects IDs, not names
public function hasRole($roles) {
    return $this->roles()->whereIn('id', $roles)->exists(); // Checking IDs
}

// RBACService constants should be IDs
const ROLE_ADMIN = 1;      // ✅ ID, not 'Admin'
const ROLE_BASIC = 2;      // ✅ ID, not 'Basic'  
const ROLE_SUPER_ADMIN = 3; // ✅ ID, not 'Super Admin'

// Use flexible comparison for mixed types
return $task->assigned_to == $user->id; // ✅ Use == not ===
```

### 6. Event Dispatching Best Practices

```php
// ✅ ALWAYS include context in task-related events
$this->dispatch('loadTask', [
    'taskId' => $task->id,
    'context' => $this->context // CRITICAL for proper permissions
]);

// ✅ Consistent event naming
$this->dispatch('close-modal-edit');  // Not 'closeModal' or 'close-edit'
$this->dispatch('loadData-tasks');    // Not 'load-tasks' or 'refresh'
```

### 7. Form State Management

```php
// ✅ Clear separation of concerns
public $canEdit = false;     // Can user edit any fields?
public $canDelete = false;   // Can user delete this item?
public $isViewOnly = false;  // Is this a read-only view?

// Set all permissions together
public function setTaskPermissions($task) {
    $this->canEdit = RBACService::canEditTask($task);
    $this->canDelete = RBACService::canDeleteTask($task);
    $this->isViewOnly = !$this->canEdit;
}
```

### 8. Debug-Friendly Development

```php
// Add conditional debug logging
if (config('app.debug') && env('RBAC_DEBUG')) {
    \Log::debug('RBAC Permission Check', [
        'method' => 'canEditTask',
        'user_id' => $user->id,
        'task_id' => $task->id,
        'context' => $this->context,
        'result' => $canEdit
    ]);
}
```

### 9. Isolated Testing Approach

```php
// Create test scripts for complex logic (like we did with test_rbac.php)
// Test RBAC logic separately from UI components
// This helps identify whether issues are in logic or presentation

$user = User::find(2);
$task = Task::find(4);
$canEdit = RBACService::canEditTask($task, $user);
echo "User {$user->id} can edit task {$task->id}: " . ($canEdit ? 'YES' : 'NO');
```

### 10. Component Lifecycle Understanding

```
Mount → Render → Events → Re-render
  ↓       ↓        ↓         ↓
Initialize → Show Form → Load Data → Update Form
(false)     (disabled)  (set perms)  (enabled)
```

**The key insight:** Prevent rendering until initialization is complete!

### 11. SPA Navigation Best Practices

**JavaScript Re-initialization Patterns:**

```javascript
// ✅ ALWAYS use dual event listeners for complex JavaScript
function initializeFeature() {
    // Your initialization code
}

document.addEventListener('DOMContentLoaded', initializeFeature);
document.addEventListener('livewire:navigated', initializeFeature);
```

**When to Use Each Pattern:**

- **@persist**: For stateful UI components (dropdowns, modals, form state)
- **@script**: For simple Alpine.js components only
- **Standard `<script>`**: For complex libraries (SortableJS, Chart.js, etc.)
- **wire:ignore**: For DOM elements modified by third-party libraries

**Alpine.js Conflict Prevention:**

```blade
{{-- ❌ AVOID: @script with complex JavaScript libraries --}}
@script
<script>
const sortable = new Sortable(container); // Alpine tries to parse this
</script>
@endscript

{{-- ✅ USE: Standard script tags for libraries --}}
<script>
function initializeSortable() {
    const sortable = new Sortable(container);
}
// Dual event listeners...
</script>
```

**Performance Monitoring:**

```javascript
// Add to debug navigation performance
Livewire.hook('navigate', () => console.log('🚀 Navigation started'));
Livewire.hook('navigated', () => console.log('✅ Navigation completed'));
```

---

### Official Documentation
- [Livewire v3 Docs](https://livewire.laravel.com)
- [Alpine.js Documentation](https://alpinejs.dev)
- [TallStackUI Documentation](https://tallstackui.com)
- [Laravel Documentation](https://laravel.com/docs)

### Useful Commands
```bash
# Create Livewire component
php artisan make:livewire Project/TaskCreate

# Clear Livewire cache
php artisan livewire:clear

# Publish TallStackUI assets
php artisan tallstackui:install

# Run migrations
php artisan migrate

# Generate IDE helper
php artisan ide-helper:generate
```

---

## 🎯 Summary

This guide provides a comprehensive foundation for building robust CRUD features using Livewire v3, Alpine.js, and TallStackUI with advanced RBAC integration and modern SPA-style navigation. The key principles are:

### Core Principles
1. **Component Initialization Order Matters**: Always guard against premature rendering
2. **Data Type Consistency**: Cast all IDs to strings for TallStackUI components
3. **Context-Aware Permissions**: Use 'global' vs 'project' context for proper RBAC
4. **Event-Driven Architecture**: Use events for component communication with proper context
5. **Security First**: Always validate inputs and check permissions
6. **SPA Navigation**: Implement wire:navigate for 2-3x faster page loads
7. **JavaScript Lifecycle Management**: Use dual event listeners for complex libraries

### Major Lessons Learned

#### RBAC Implementation
1. **The Root Cause**: Most UI issues stem from components rendering before data/permissions are loaded
2. **Type Safety**: TallStackUI select components require consistent string types
3. **Permission Context**: Different pages ('My Tasks' vs 'Project Tasks') need different permission scopes
4. **Always Include Assigned Users**: Dropdowns must show currently assigned users even if permissions wouldn't normally allow it
5. **Test Logic Separately**: Use standalone test scripts to verify RBAC logic independent of UI

#### SPA Navigation with wire:navigate
1. **JavaScript Re-initialization**: Traditional `DOMContentLoaded` only runs once; use `livewire:navigated` for subsequent navigations
2. **Alpine.js Conflicts**: Don't use `@script` with complex JavaScript libraries; Alpine tries to parse them as expressions
3. **State Preservation**: Use `@persist` for stateful UI components like dropdowns and forms
4. **Performance Benefits**: Achieves 2-3x faster navigation by preserving assets and replacing only `<body>` content
5. **Dual Event Pattern**: Essential for complex libraries like SortableJS to work across navigation transitions

### Prevention Strategy

#### RBAC
- Use conditional rendering to prevent premature form display
- Create base RBAC components for consistent permission handling
- Always cast IDs to strings for select components
- Include context in all task-related event dispatches
- Test permission logic separately from UI components

#### SPA Navigation
- Add `wire:navigate` incrementally, starting with main navigation
- Use `@persist` for dropdowns and stateful components
- Implement dual event listeners (`DOMContentLoaded` + `livewire:navigated`) for complex JavaScript
- Avoid `@script` for third-party libraries; use standard `<script>` tags
- Monitor navigation performance with browser developer tools

### Architecture Patterns

#### Component Communication
```php
// Event-driven communication with context
$this->dispatch('loadTask', ['taskId' => $id, 'context' => 'project']);
```

#### JavaScript Lifecycle
```javascript
// Dual initialization pattern for SPA compatibility
function initializeFeature() { /* initialization code */ }
document.addEventListener('DOMContentLoaded', initializeFeature);
document.addEventListener('livewire:navigated', initializeFeature);
```

#### State Preservation
```blade
{{-- Preserve stateful components across navigation --}}
@persist('dropdown-state')
    <div class="dropdown"><!-- dropdown content --></div>
@endpersist
```

By following these patterns and understanding the critical lessons learned from implementing both RBAC and SPA navigation, you can build maintainable, secure, fast, and user-friendly features that integrate seamlessly with your Laravel application.

### What Made This Experience Valuable

#### RBAC Implementation
This implementation taught us that **debugging complex UI interactions requires isolating the problem layers**:
1. First verify core logic works (RBAC permissions)
2. Then verify data flow (events, context)
3. Finally verify UI rendering (component lifecycle)

#### SPA Navigation Implementation
The wire:navigate implementation revealed that **modern web app performance comes from understanding JavaScript lifecycle patterns**:
1. Traditional page loads vs. SPA navigation events
2. When to preserve state vs. when to re-initialize
3. How different JavaScript patterns (Alpine.js vs. vanilla JS) interact with SPA navigation
4. The balance between performance and functionality

The systematic approach of creating test scripts, adding debug output, understanding the Livewire component lifecycle, and implementing proper JavaScript re-initialization patterns was crucial to building a fast, modern web application that maintains Laravel's simplicity.

---

*Happy coding! 🚀*

*Remember: When things don't work as expected, step back and test each layer independently. The issue is usually in the integration, not the individual parts.*
