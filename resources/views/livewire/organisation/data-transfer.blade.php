<div class="space-y-6">

    {{-- Step 1: From Organisation --}}
    @if($step === 1)
        <div wire:key="step-1" class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Data Transfer (From Organisation)</h2>

            <form wire:submit.prevent="goToStep2" class="space-y-4">
                @include('organisation.partials.organisation-dropdowns', [
                    'wireModelPrefix' => 'from',
                    'type' => $type ?? null, // pass type if needed
                ])

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                            wire:click="resetFilters">
                        Clear
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Next
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Step 2: To Organisation --}}
    @if($step === 2)
        <div wire:key="step-2" class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Data Transfer (To Organisation)</h2>

            <form wire:submit.prevent="processTransfer" class="space-y-4">
                @include('organisation.partials.organisation-dropdowns', [
                    'wireModelPrefix' => 'to',
                    'type' => $type ?? null, // pass type if needed
                ])

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                            wire:click="resetFilters">
                        Clear
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Transfer
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
