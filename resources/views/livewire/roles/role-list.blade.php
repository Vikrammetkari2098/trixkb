<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($roles as $role)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-5">

                <!-- Header: Role Name & Dropdown -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-bold text-lg md:text-xl hover:text-blue-600 transition-colors truncate">
                            {{ $role->name }}
                        </h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $role->members->count() }} Members)</span>
                    </div>
                    <div class="flex items-center">
                        <x-dropdown icon="ellipsis-vertical" static>
                            <x-dropdown.items
                                icon="pencil-square"
                                text="Edit"
                                x-on:click="$modalOpen('modal-edit-role')"
                                @click="$wire.dispatch('loadData-edit-role', {roleId: {{ $role->id }}});"
                            />
                            @if($role->slug !== 'admins')
                                <x-dropdown.items
                                    icon="trash"
                                    text="Delete"
                                    @click="$wire.dispatch('delete-role', {roleId: {{ $role->id }}});"
                                />
                            @endif
                        </x-dropdown>
                    </div>
                </div>

                <!-- Members Avatars -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($role->members->count() > 0)
                        @foreach($role->members->take(4) as $member)
                            @php
                                $avatars = ['avatar2.jpeg','avatar3.jpeg','avatar4.jpeg','avatar5.jpeg'];
                                $avatarImage = $member->profile_image && file_exists(public_path('assets/avatars/' . $member->profile_image))
                                    ? asset('assets/img/avatars/' . $member->profile_image)
                                    : asset('assets/img/avatars/' . $avatars[array_rand($avatars)]);
                            @endphp
                            <div class="w-12 h-12 rounded-full border-2 border-white overflow-hidden flex items-center justify-center hover:scale-110 transition-transform">
                                <img class="object-cover w-full h-full" src="{{ $avatarImage }}" alt="{{ $member->name }}" title="{{ $member->name }}">
                            </div>
                        @endforeach

                        @if($role->members->count() > 4)
                            <div class="w-12 h-12 bg-gray-500 rounded-full border-2 border-white flex items-center justify-center text-white text-sm font-semibold">
                                +{{ $role->members->count() - 4 }}
                            </div>
                        @endif
                    @else
                        <div class="w-12 h-12 rounded-full border-2 border-white flex items-center justify-center bg-gray-200">
                            <img src="{{ asset('assets/img/avatars/avatar5.jpeg') }}" alt="No members" class="object-cover w-full h-full">
                        </div>
                    @endif
                </div>

                <!-- Members Emails -->
                <div class="flex flex-col gap-1">
                    @foreach($role->members->take(3) as $member)
                        <div class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                            {{ $member->name }} ({{ $member->email }})
                        </div>
                    @endforeach
                    @if($role->members->count() > 3)
                        <div class="text-sm text-gray-500">+{{ $role->members->count() - 3 }} more</div>
                    @endif
                </div>

            </div>
        </div>
    @endforeach
</div>
