<div wire:init="loadData">
    <div x-data="{selectedProjectId: null}">
        <livewire:projects.project-delete />

        <x-modal id="modal-update" center>
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit project</h2>
            <p class="text-sm text-gray-500 mb-4">Edit your project details here.</p>
            <livewire:projects.project-edit />
        </x-modal>

        <!-- Projects Overview Component -->
        <livewire:projects.projects-overview />

        <!-- Projects List Component -->
        <livewire:projects.projects-list />
    </div>
</div>
