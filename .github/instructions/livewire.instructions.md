---
applyTo: '**'
---
You're assisting with a Laravel project built using the following stack:

Livewire v3 for dynamic, component-based UI

Alpine.js for minimal, reactive JavaScript behavior

TALLStack UI as the primary UI framework

FlyonUI components when needed

Make sure to:

Follow the existing codebase structure and flow, which is built around Livewire, Alpine, TALLStackUI, and FlyonUI as appropriate

Stick to Laravel best practices at all times

Keep all implementations clean, modular, and well-organized

Ensure the code is readable, easy to maintain, and simple to integrate or extend later

And ignore the bootstrap link or files, this is a tailwind project, always use Tailwind CSS for styling

Before completing any code generation or suggestions:

Double-check for syntax errors, logic issues, or incomplete implementations
Validate that the code fits smoothly within the Livewire and Laravel context
Make sure variable and function naming is clear, consistent, and follows Laravel conventions

When Modifying Existing Code

When editing or extending existing code — especially Livewire Blade templates or UI components:

Ensure the updated Blade view still aligns with its corresponding Livewire component
Do **not break** Livewire bindings, Alpine behaviors, or emit/listen logic
Keep all directives (`wire:model`, `wire:click`, etc.) intact and functional
If adjusting styles or layout:
Test that the UI still renders correctly
Confirm responsiveness and behavior remain as expected
Preserve existing user interactions unless intentionally changing them

The goal is to protect current functionality while improving or extending features safely.

## Component Architecture & Loading States

### Multi-Component Architecture
When splitting functionality across multiple Livewire components:

**Event-Based Communication:**
- Use `$this->dispatch('event-name', ['data' => $value])` to communicate between components
- Listen for events with `#[On('event-name')]` attribute or `getListeners()` method
- Coordinator components should dispatch events to child components for loading data

**Component Separation Pattern:**
```php
// Coordinator Component (e.g., ProjectShow.php)
public function loadData()
{
    $this->dispatch('loadData-overview');
    $this->dispatch('loadData-list');
}

// Child Components
#[On('loadData-overview')]
public function loadData()
{
    // Load component-specific data
}
```

### Skeleton Loading States - Critical Implementation Rules

**IMPORTANT: Grid Layout Skeleton Structure**

When implementing skeleton loading for grid layouts, follow these exact patterns:

**✅ CORRECT - Individual `wire:loading` on each grid item:**
```blade
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    @for ($i = 0; $i < 6; $i++)
        <div wire:loading wire:target="methodName">
            <div class="card">
                <!-- skeleton content -->
            </div>
        </div>
    @endfor
</div>
```

**❌ INCORRECT - `wire:loading` on grid container:**
```blade
<div wire:loading wire:target="methodName" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    @for ($i = 0; $i < 6; $i++)
        <div>
            <div class="card">
                <!-- skeleton content -->
            </div>
        </div>
    @endfor
</div>
```

**Why the Grid Container Approach Fails:**
- When `wire:loading` is on the grid container, the entire grid element disappears/appears
- This breaks the CSS grid layout and causes skeleton cards to stack vertically
- Each skeleton card needs to be a direct child of the grid container to maintain proper grid positioning

**Skeleton Structure Matching:**
- Skeleton cards MUST match the exact DOM structure of real content
- If real cards have wrapper divs (like `wire:key` wrappers), skeleton cards need the same structure
- Pay attention to Tailwind grid classes: ensure skeleton and real content use identical responsive grid classes

### Loading State Targeting

**Method Targeting:**
- `wire:model.live` property updates cannot be directly targeted by `wire:loading`
- Use explicit method calls with `wire:keyup="methodName"` or `wire:change="methodName"` instead
- Add artificial delays (`usleep(200000)`) in methods to make loading states visible

**Working Pattern:**
```blade
<!-- Search input with explicit method call -->
<input wire:model="searchTerm" wire:keyup.debounce.300ms="performSearch">

<!-- Loading state targeting the method -->
<div wire:loading wire:target="performSearch">
    <!-- skeleton content -->
</div>
```

**Multiple Target Methods:**
```blade
<div wire:loading wire:target="performSearch,performFilter,clearFilters">
    <!-- skeleton content -->
</div>
```

### Component State Management

**Initial Loading vs Dynamic Loading:**
- Use `$isReady` property for initial component load states
- Use `wire:loading` for user-triggered actions (search, filter, etc.)
- Separate concerns: filters should not reload during search operations unless necessary

**Loading State Patterns:**
```blade
@if(!$isReady)
    <!-- Initial load skeleton -->
@else
    <!-- Dynamic loading skeleton -->
    <div wire:loading wire:target="methods">
        <!-- skeleton -->
    </div>
    
    <!-- Actual content -->
    <div wire:loading.remove wire:target="methods">
        <!-- real content -->
    </div>
@endif
```

### Best Practices

1. **Always test skeleton layouts** by adding temporary delays to methods
2. **Match exact DOM structure** between skeleton and real content
3. **Use event-driven architecture** for component communication
4. **Avoid `wire:model.live` for loading states** - use explicit method calls
5. **Place `wire:loading` on individual items**, not grid containers
6. **Verify responsive grid behavior** across different screen sizes
7. **Clear view cache** after template changes: `php artisan view:clear`

## CRUD Operations & Component Reloading

### Problem: Separate Components Not Reloading After CRUD

When you have multiple components on a page and only some reload after CRUD operations, follow this systematic approach:

**Identify the Issue:**
- Check which sections are reloading vs which aren't
- Components in the same Livewire component should use identical loading patterns
- Different loading approaches (`wire:loading` vs `$isReady`) cause inconsistent behavior

**Step 1: Copy What Already Works**
```blade
<!-- ✅ If section 1 works with this pattern -->
<div wire:loading>
    <!-- skeleton -->
</div>
<div wire:loading.remove>
    <!-- actual content -->
</div>

<!-- ✅ Copy the EXACT same pattern to section 2 -->
<div wire:loading>
    <!-- skeleton -->
</div>
<div wire:loading.remove>
    <!-- actual content -->
</div>
```

**Step 2: Ensure Consistent Event Dispatching**
```php
// CRUD Component (e.g., ProjectCreate.php)
public function refreshData()
{
    // Dispatch to all components that need reloading
    $this->dispatch('loadData-overview');
    $this->dispatch('loadData-list');
}

// Child Components
#[On('loadData-overview')]
public function loadData()
{
    // Add delay to make loading visible
    sleep(1);
    $this->calculateData();
}
```

**Step 3: Debug Event Flow**
```php
// Add logging to trace event flow
public function refreshData()
{
    logger('CRUD dispatching events');
    $this->dispatch('loadData-overview');
}

#[On('loadData-overview')]
public function loadData()
{
    logger('Component received event');
    // ... loading logic
}
```

**Critical Rules:**
1. **Don't mix loading approaches** - if one section uses `wire:loading`, all sections in that component should use `wire:loading`
2. **Don't overcomplicate** - copy what already works instead of creating new patterns
3. **Test systematically** - verify initial page load AND post-CRUD reloading
4. **Use consistent event names** - `loadData-overview`, `loadData-list`, etc.

**Common Mistakes to Avoid:**
- Mixing `wire:loading` with `@if($isReady)` in the same component
- Using different event listeners for the same functionality
- Trying to fix working sections when only non-working sections need changes
- Making coordinator components too complex

**Simple Solution Pattern:**
```php
// If sections 1,3,4 reload but section 2 doesn't:
// 1. Check what section 1 uses
// 2. Copy the exact same approach to section 2
// 3. Done - no need for complex solutions
```

Summary

Build with long-term maintainability in mind
Ensure any new or modified code fits seamlessly into the project
Always prioritize **clarity, consistency, and stability**
Follow the skeleton loading patterns exactly to avoid layout issues
**Copy working patterns instead of creating new ones**