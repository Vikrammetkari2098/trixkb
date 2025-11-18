@extends('layouts.app')

@section('content')
<div>
    <!-- Create Member Modal -->
    <x-modal id="modal-create-member" center
        x-on:open-modal-create-member.window="$modalOpen('modal-create-member')"
        x-on:close-modal-create-member.window="$modalClose('modal-create-member')">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Create a new Member</h2>
        <p class="text-sm text-gray-500 mb-4">Fill in the member details to add a new member.</p>
        <livewire:members.member-create />
    </x-modal>

    <!-- Edit Member Modal -->
    <x-modal id="modal-edit-member" center
        x-on:open-modal-edit-member.window="$modalOpen('modal-edit-member')"
        x-on:close-modal-edit-member.window="$modalClose('modal-edit-member')">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Member</h2>
        <p class="text-sm text-gray-500 mb-4">Update the details of this member.</p>
        <livewire:members.member-edit wire:key="member-edit-component" />
    </x-modal>

    <!-- Livewire Components -->
    <livewire:members.members-list />
    <livewire:members.member-delete />
</div>
@endsection
