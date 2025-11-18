<div x-data="{ currentTab: 'personal' }">
    <x-errors />
    
    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button @click="currentTab = 'personal'" 
                    :class="currentTab === 'personal' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                Personal Information
            </button>
            <button @click="currentTab = 'professional'" 
                    :class="currentTab === 'professional' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                Professional Details
            </button>
            <button @click="currentTab = 'preferences'" 
                    :class="currentTab === 'preferences' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                Preferences
            </button>
        </nav>
    </div>

    <form id="form-edit" wire:submit.prevent='update' enctype="multipart/form-data">
        @csrf
        
        <!-- Personal Information Tab -->
        <div x-show="currentTab === 'personal'" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <x-input label="First Name *" id="first_name" wire:model.defer="first_name" invalidate />
                </div>
                <div>
                    <x-input label="Last Name *" id="last_name" wire:model.defer="last_name" invalidate />
                </div>
                <div>
                    <x-input label="Email *" id="email" type="email" wire:model.defer="email" invalidate />
                </div>
                <div>
                    <x-input label="Phone" id="phone" type="text" wire:model.defer="phone" invalidate />
                </div>
            </div>

            <div>
                <x-textarea label="Bio" id="bio" wire:model.defer="bio" rows="4" 
                           hint="Tell us about yourself (max 500 characters)" />
                @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-input label="Location" id="location" wire:model.defer="location" 
                        hint="City, Country" />
            </div>

            <div>
                <x-input label="Profile Photo" id="profile_photo" type="file" wire:model="profile_photo" 
                        hint="JPG or PNG, max 1MB" />
                @error('profile_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Professional Details Tab -->
        <div x-show="currentTab === 'professional'" class="space-y-6">
            <div>
                <x-input label="Website" id="website" type="url" wire:model.defer="website" 
                        hint="Your personal or professional website" />
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <x-input label="GitHub Username" id="github_username" wire:model.defer="github_username" 
                            hint="Without @" />
                </div>
                <div>
                    <x-input label="LinkedIn Username" id="linkedin_username" wire:model.defer="linkedin_username" 
                            hint="Without @" />
                </div>
            </div>

            <!-- Skills Section -->
            <div x-data="{ newSkill: '' }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                <div class="space-y-3">
                    <!-- Add Skill Input -->
                    <div class="flex space-x-2">
                        <input type="text" x-model="newSkill" @keydown.enter.prevent="
                            if(newSkill.trim()) {
                                $wire.addSkill(newSkill.trim());
                                newSkill = '';
                            }
                        " placeholder="Add a skill..." 
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <button type="button" @click="
                            if(newSkill.trim()) {
                                $wire.addSkill(newSkill.trim());
                                newSkill = '';
                            }
                        " class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add
                        </button>
                    </div>

                    <!-- Skills List -->
                    @if(count($skills) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills as $index => $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $skill }}
                                    <button type="button" wire:click="removeSkill({{ $index }})" 
                                            class="ml-2 inline-flex items-center p-0.5 rounded-full text-blue-400 hover:bg-blue-200 hover:text-blue-600 focus:outline-none">
                                        <span class="icon-[tabler--x] text-xs"></span>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Preferences Tab -->
        <div x-show="currentTab === 'preferences'" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <x-select.styled 
                        id="timezone-select"
                        label="Timezone *"
                        :options="collect($this->getTimezoneOptions())->map(fn($label, $value) => ['label' => $label, 'value' => $value])->values()->toArray()"
                        select="label:label|value:value"
                        wire:model.defer="timezone" />
                </div>
                <div>
                    <x-select.styled 
                        id="language-select"
                        label="Language *"
                        :options="collect($this->getLanguageOptions())->map(fn($label, $value) => ['label' => $label, 'value' => $value])->values()->toArray()"
                        select="label:label|value:value"
                        wire:model.defer="language" />
                </div>
            </div>

            <!-- Notification Preferences -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Notification Preferences</label>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                            <p class="text-sm text-gray-500">Receive general email notifications</p>
                        </div>
                        <x-toggle wire:model.defer="notification_preferences.email_notifications" />
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Task Assignments</h4>
                            <p class="text-sm text-gray-500">Get notified when tasks are assigned to you</p>
                        </div>
                        <x-toggle wire:model.defer="notification_preferences.task_assignments" />
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Project Updates</h4>
                            <p class="text-sm text-gray-500">Receive notifications about project changes</p>
                        </div>
                        <x-toggle wire:model.defer="notification_preferences.project_updates" />
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Team Mentions</h4>
                            <p class="text-sm text-gray-500">Get notified when mentioned in team discussions</p>
                        </div>
                        <x-toggle wire:model.defer="notification_preferences.team_mentions" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
            <x-button x-on:click="$modalClose('modal-edit-profile')" color="gray">
                Cancel
            </x-button>
            <x-button type="submit" color="green" loading>
                Update Profile
            </x-button>
        </div>
    </form>
</div>
