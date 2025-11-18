<div>
    <x-errors />

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">

            <div>
                <x-select.styled
                    id="ministry_id"
                    label="Ministry *"
                    :options="$ministries"
                    select="label:name|value:id"
                    wire:model.defer="ministry_id"
                />
            </div>

            <div>
                <x-select.styled
                    id="department_id"
                    label="Department"
                    :options="$departments"
                    select="label:name|value:id"
                    wire:model.defer="department_id"
                />
            </div>

            <div>
                <x-select.styled
                    id="case_category_id"
                    label="Case Category *"
                    :options="$caseCategories"
                    select="label:name|value:id"
                    wire:model.defer="case_category_id"
                />


            </div>

            <div>
                <x-select.styled
                    id="sub_case_category_1_id"
                    label="Sub Case Category 1"
                    :options="$subCaseCategories1"
                    select="label:name|value:id"
                    wire:model.defer="sub_case_category_1_id"
                />
            </div>

            <div>
                <x-select.styled
                    id="sub_case_category_2_id"
                    label="Sub Case Category 2"
                    :options="$subCaseCategories2"
                    select="label:name|value:id"
                    wire:model.defer="sub_case_category_2_id"
                />
            </div>

            <div class="sm:col-span-2">
                <x-select.styled
                    id="status"
                    label="Status *"
                    :options="[
                        ['name' => 'Active', 'id' => 1],
                        ['name' => 'Inactive', 'id' => 0]
                    ]"
                    select="label:name|value:id"
                    wire:model.defer="status"
                />
            </div>

        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>Save Category Matrix</x-button>
        </div>
    </form>
</div>
