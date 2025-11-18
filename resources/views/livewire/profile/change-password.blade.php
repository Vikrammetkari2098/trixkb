<div>
    <x-errors />
    <form wire:submit.prevent="update">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-input label="Old Password *" type="password" wire:model.defer="old_password" />
            </div>

            <div>
                <x-input label="New Password *" type="password" wire:model.defer="new_password" />
            </div>

            <div>
                <x-input label="Confirm Password *" type="password" wire:model.defer="confirm_password" />
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-2">
            <x-button x-on:click="$modalClose('modal-change-password')" color="gray">
                Cancel
            </x-button>
            <x-button type="submit" color="green" loading>
                Update Password
            </x-button>
        </div>
    </form>
</div>
