<div wire:init="loadData">
    <!-- Header Section -->
    <div class="card mb-6">
        <div class="card-body">
            <!-- Loading state -->
            <div wire:loading>
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <div class="skeleton skeleton-animated h-8 w-48 mb-2 bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-4 w-64 bg-gray-200"></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="skeleton skeleton-animated h-6 w-20 rounded bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-10 w-32 rounded bg-gray-200"></div>
                    </div>
                </div>
            </div>
            
            <!-- Actual content -->
            <div wire:loading.remove>
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Projects Overview</h1>
                        <p class="text-lg text-gray-600">Manage and track all your projects in one place</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-badge text="{{ $totalProjects }} Total" color="blue" />
                        <x-button color="green" x-on:click="$modalOpen('modal-create')">
                            <span class="icon-[tabler--plus] w-4 h-4 mr-2"></span>
                            New Project
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Loading skeletons -->
        @for ($i = 0; $i < 4; $i++)
            <div wire:loading>
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-gray-100 rounded-lg mr-4">
                                <div class="skeleton skeleton-animated h-6 w-6 bg-gray-200"></div>
                            </div>
                            <div>
                                <div class="skeleton skeleton-animated h-4 w-24 mb-2 bg-gray-200"></div>
                                <div class="skeleton skeleton-animated h-8 w-12 bg-gray-200"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor

        <!-- Actual Statistics -->
        <!-- Total Projects -->
        <div wire:loading.remove class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg mr-4">
                        <span class="icon-[tabler--folder] text-blue-600 w-6 h-6"></span>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-600">Total Projects</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div wire:loading.remove class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg mr-4">
                        <span class="icon-[tabler--clock] text-green-600 w-6 h-4"></span>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-600">Active Projects</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $activeProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Projects -->
        <div wire:loading.remove class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg mr-4">
                        <span class="icon-[tabler--check] text-purple-600 w-6 h-4"></span>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-600">Completed</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $completedProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Projects -->
        <div wire:loading.remove class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg mr-4">
                        <span class="icon-[tabler--alert-triangle] text-red-600 w-6 h-4"></span>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-600">Overdue</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $overdueProjects }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
