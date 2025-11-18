<div class="bg-white min-h-screen antialiased p-6">

   <!-- Filters -->
     <div class="flex justify-end mb-4">
        <x-button color="green" x-on:click="$modalOpen('modal-create-member')" class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Member
        </x-button>
    </div>
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
        <h2 class="text-2xl font-semibold">Members</h2>
        <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4">
            <!-- Role Filter Buttons -->
            <div class="flex space-x-2 text-sm font-medium">
                @foreach(['Admin','Super Admin','Editor','Viewer'] as $role)
                    <button
                        wire:click="setRoleFilter('{{ $role }}')"
                        class="flex items-center px-3 py-1 rounded-lg transition duration-150 shadow-sm
                            {{ $activeRole === $role ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $role }}
                        <span class="ml-1 text-xs font-bold bg-white px-1 py-0.5 rounded-full">
                            {{ $this->getRoleCount($role) }}
                        </span>
                    </button>
                @endforeach
            </div>
            <!-- Search Input -->
            <input
                type="text"
                placeholder="Search members..."
                wire:model.debounce.300ms="search"
                class="px-3 py-1 rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-purple-500"
            >

            <!-- Quantity Dropdown -->
                <div class="dropdown relative inline-flex  rounded px-3 py-1">
                <button id="dropdown-quantity" type="button" class="dropdown-toggle btn btn-primary flex items-center justify-between w-full" aria-haspopup="menu" aria-expanded="false" aria-label="Quantity Dropdown">
                    {{ $quantity ?? 'Select Quantity' }}
                    <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4 ml-2"></span>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60 mt-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-quantity">
                    <li><a href="#" class="dropdown-item" wire:click.prevent="$set('quantity', 5)">5</a></li>
                    <li><a href="#" class="dropdown-item" wire:click.prevent="$set('quantity', 10)">10</a></li>
                    <li><a href="#" class="dropdown-item" wire:click.prevent="$set('quantity', 25)">25</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Members Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left cursor-pointer" wire:click="sortBy('name')">Member</th>
                    <th class="px-4 py-3 text-left cursor-pointer" wire:click="sortBy('email')">Email</th>
                    <th class="px-4 py-3 text-left cursor-pointer" wire:click="sortBy('role')">Role</th>
                    <th class="px-4 py-3 text-left cursor-pointer" wire:click="sortBy('status')">Status</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @foreach($rows as $member)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-3 whitespace-nowrap text-gray-900 font-medium flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                            <span class="icon-[ic--sharp-account-circle] size-5"></span>
                        </div>
                        <span>{{ $member->name }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $member->email }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @php
                            $roleName = $member->roles->first()?->name ?? 'N/A';
                        @endphp
                        <span class="{{ $this->getRoleColor($roleName) }} px-2 py-1 inline-flex text-xs font-semibold rounded-full">
                            {{ $roleName }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center space-x-1 {{ $this->getStatusColor($member->status) }}">
                            <span class="icon-[mdi--circle-slice-8] size-2.5"></span>
                            <span>{{ $this->getStatusText($member->status) }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-right flex space-x-2 justify-end">
                        <button
                            class="btn btn-text btn-success"
                            wire:click="$dispatch('loadData-edit-member', { id: {{ $member->id }} })"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-text btn-error"
                            wire:click="$dispatch('delete-member', { memberId: {{ $member->id }} })"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-4">
            {{ $rows->links() }}
        </div>
    </div>
    <style>
        [class*="icon-"] { display: inline-block; width: 1.25rem; height: 1.25rem; background-color: currentColor; mask-repeat: no-repeat; mask-size: cover; }
    </style>
</div>


