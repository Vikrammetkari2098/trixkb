<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- Ministry --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ministry</label>
        <select wire:model="{{ $wireModelPrefix }}MinistryFilter"
                class="w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Ministry</option>
            @foreach($ministries_list as $ministry)
                <option value="{{ $ministry->id }}">{{ $ministry->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Department --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
        <select wire:model="{{ $wireModelPrefix }}DepartmentFilter"
                class="w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Department</option>
            @foreach($departments_list as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Segment --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Segment</label>
        <select wire:model="{{ $wireModelPrefix }}SegmentFilter"
                class="w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Segment</option>
            @foreach($segments_list as $segment)
                <option value="{{ $segment->id }}">{{ $segment->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Unit --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Unit/Section</label>
        <select wire:model="{{ $wireModelPrefix }}UnitFilter"
                class="w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Unit</option>
            @foreach($units_list as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Sub Unit --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Unit</label>
        <select wire:model="{{ $wireModelPrefix }}SubUnitFilter"
                class="w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Sub Unit</option>
            @foreach($subUnits_list as $subUnit)
                <option value="{{ $subUnit->id }}">{{ $subUnit->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Only show Wiki Type and Organisation Type if type != 2 --}}
    @if(!isset($type) || $type != 2)
        {{-- Wiki Type --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Wiki Type</label>
            <select wire:model="{{ $wireModelPrefix }}WikiType"
                    class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Select Wiki Type</option>
                @foreach($wikiTypes as $wt)
                    <option value="{{ $wt }}">{{ $wt }}</option>
                @endforeach
            </select>
        </div>

        {{-- Organisation Type --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Organisation Type</label>
            <select wire:model="{{ $wireModelPrefix }}OrganisationType"
                    class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Select Organisation Type</option>
                @foreach($organisationTypes as $key => $val)
                    <option value="{{ $val }}">{{ $key }}</option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- Include Child Data --}}
    <div class="flex items-center space-x-2 mt-2">
        <input type="checkbox" wire:model="{{ $wireModelPrefix }}ChildDataIncluded" class="h-4 w-4 rounded">
        <span class="text-sm text-gray-700">Include child data?</span>
    </div>

</div>
