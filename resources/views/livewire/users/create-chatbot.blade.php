<div class="p-6 bg-white rounded-lg shadow-md">
    <x-errors />

    <form wire:submit.prevent="register" id="form-create-chatbot">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <!-- Ministry -->
            <div class="sm:col-span-1">
                <x-select.styled
                    label="Ministry *"
                    :options="collect($ministries)->map(fn($m) => ['name' => $m->name, 'id' => $m->ministry_id])->toArray()"
                    select="label:name|value:id"
                    wire:model="ministry_id"
                    placeholder="Select Ministry"
                    :key="count($ministries)"
                />
            </div>

            <!-- Department -->
            <div class="sm:col-span-1">
                <x-select.styled
                    label="Department"
                    :options="collect($departments)->map(fn($d) => ['name' => $d->name, 'id' => $d->id])->toArray()"
                    select="label:name|value:id"
                    wire:model="department_id"
                    placeholder="Select Department"
                    :key="count($departments)"
                />
            </div>

            <!-- Space -->
            <div class="sm:col-span-1">
                <x-select.styled
                    label="Space"
                    :options="collect($spaces)->map(fn($s) => ['name' => $s->name, 'id' => $s->id])->toArray()"
                    select="label:name|value:id"
                    wire:model="space_id"
                    placeholder="Select Space"
                    :key="count($spaces)"
                />
            </div>

            <!-- Organisation -->
            <div class="sm:col-span-1">
                <x-select.styled
                    label="Organisation *"
                    :options="collect($organisations)->map(fn($o) => ['name' => $o->name, 'id' => $o->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.lazy="organisation_id"
                    placeholder="Select Organisation"
                />
            </div>

            <!-- Main Category -->
            <div class="sm:col-span-1">
                <x-input
                    label="Main Category *"
                    wire:model="main_category"
                    placeholder="Enter main category"
                />
            </div>

            <!-- Region -->
            <div class="sm:col-span-1">
                <x-select.styled
                    label="Region *"
                    :options="collect($regions)->map(fn($r, $id) => ['name' => $r, 'id' => $id])->toArray()"
                    select="label:name|value:id"
                    wire:model="region"
                    placeholder="Select Region"
                    :key="count($regions)"
                />
            </div>

            <!-- Language -->
            <div class="sm:col-span-1">
                <x-select.styled
                    label="Language *"
                    :options="collect($languages)->map(fn($l, $id) => ['name' => $l, 'id' => $id])->toArray()"
                    select="label:name|value:id"
                    wire:model="language_id"
                    placeholder="Select Language"
                    :key="count($languages)"
                />
            </div>

            <!-- Service -->
            <div class="sm:col-span-1">
                <x-input
                    label="Service *"
                    wire:model="service"
                    placeholder="Enter service"
                />
            </div>

            <!-- Sub Service -->
            <div class="sm:col-span-1">
                <x-input
                    label="Sub Service"
                    wire:model="sub_service"
                    placeholder="Enter sub service"
                />
            </div>

            <!-- Description -->
            <div class="sm:col-span-2">
                <x-textarea
                    label="Description"
                    wire:model="description"
                    placeholder="Enter description"
                    rows="4"
                />
            </div>

        </div>

        <div class="flex justify-end mt-6 space-x-3">
            <x-button type="submit" color="blue" loading>
                Create Chatbot
            </x-button>
        </div>
    </form>
</div>
