<div x-data class="p-6 bg-white rounded-2xl shadow-lg space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">Data Transfer (From Organisation)</h2>
    </div>

    <!-- Filters Form -->
    <form id="data-transfer-form" class="space-y-6">
        <!-- Row 1: Ministry & Department -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Ministry -->
            <div>
                <label for="ministry_filter_id" class="block text-sm font-medium text-gray-700 mb-1">Ministry</label>
                <select name="ministry_filter" id="ministry_filter_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Ministry</option>
                    @foreach($ministries_list as $ministry)
                        <option value="{{ $ministry['ministry_id'] }}">{{ $ministry['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department -->
            <div>
                <label for="department_filter_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select name="department_filter" id="department_filter_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Department</option>
                    @foreach($departments_list as $department)
                        <option value="{{ $department['department_id'] }}">{{ $department['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 2: Segment & Unit -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Segment -->
            <div>
                <label for="segment_filter_id" class="block text-sm font-medium text-gray-700 mb-1">Division</label>
                <select name="segment_filter" id="segment_filter_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Division</option>
                    @foreach($segments_list as $segment)
                        <option value="{{ $segment['segment_id'] }}">{{ $segment['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Unit -->
            <div>
                <label for="unit_filter_id" class="block text-sm font-medium text-gray-700 mb-1">Unit/Section</label>
                <select name="unit_filter" id="unit_filter_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Unit/Section</option>
                    @foreach($units_list as $unit)
                        <option value="{{ $unit['unit_id'] }}">{{ $unit['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 3: Sub Unit & Wiki Type -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Sub Unit -->
            <div>
                <label for="sub_unit_filter_id" class="block text-sm font-medium text-gray-700 mb-1">Sub Unit/Sub Section</label>
                <select name="sub_unit_filter" id="sub_unit_filter_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Sub Unit/Sub Section</option>
                    @foreach($subUnits_list as $subUnit)
                        <option value="{{ $subUnit['sub_unit_id'] }}">{{ $subUnit['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Wiki Type -->
            @if($wikiTypes)
            <div>
                <label for="wiki_type_id" class="block text-sm font-medium text-gray-700 mb-1">Wiki Type</label>
                <select name="wiki_type" id="wiki_type_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Wiki Type</option>
                    @foreach($wikiTypes as $wikiType)
                        <option value="{{ $wikiType }}">{{ $wikiType }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>

        <!-- Row 4: Organisation Type & Include Child Data -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <!-- Organisation Type -->
            <div>
                <label for="organisation_type_id" class="block text-sm font-medium text-gray-700 mb-1">Organisation Type</label>
                <select name="organisation_type" id="organisation_type_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Organisation Type</option>
                    @foreach($organisationTypes as $key => $organisationType)
                        <option value="{{ $organisationType }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Include Child Data -->
            <div class="flex items-center mt-4 md:mt-0">
                <input type="checkbox" name="child_data_included" value="1"
                       {{ old('child_data_included') ? 'checked' : '' }} checked
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="child_data_included" class="ml-2 block text-sm text-gray-700 font-medium">
                    Include child data?
                </label>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-2 mt-4">
            <button type="button"
                    onclick="clearFilter()"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 flex items-center gap-2">
                <i class="fa fa-times"></i> Clear
            </button>

            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center gap-2">
                <i class="fa fa-arrow-right"></i> Next
            </button>
        </div>
    </form>
</div>

<!-- Clear Filter Script -->
<script>
    function clearFilter() {
        ['ministry_filter_id', 'department_filter_id', 'segment_filter_id', 'unit_filter_id', 'sub_unit_filter_id', 'wiki_type_id', 'organisation_type_id']
        .forEach(id => {
            let el = document.getElementById(id);
            if(el) el.selectedIndex = 0;
            $(el).trigger('change'); // For select2 if used
        });
    }
</script>
