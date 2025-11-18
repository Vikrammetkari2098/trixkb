<?php

namespace App\Livewire\Organisation\Matrix;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Organisation;
use App\Models\Space;
use TallStackUi\Traits\Interactions;

class MatrixList extends Component
{
    use WithPagination, Interactions;

    protected $paginationTheme = 'tailwind';

    public $statusFilter = '';
    public $categoryFilter = '';
    public $ministryFilter = '';
    public $departmentFilter = '';
    public $segmentFilter = '';
    public $unitFilter = '';
    public $subUnitFilter = '';
   public $showViewModal = false;
    public $selectedOrganisation;

    public $organisationStatus = [
        ['value' => 1, 'name' => 'Active'],
        ['value' => 0, 'name' => 'Inactive'],
    ];

    public $organisationCategories = [
        ['value' => 1, 'name' => 'Kementerian'],
        ['value' => 2, 'name' => 'Jabatan/Agensi'],
        ['value' => 3, 'name' => 'Division'],
        ['value' => 4, 'name' => 'Unit/Section/Cawangan'],
        ['value' => 5, 'name' => 'Sub Unit/Sub Section/Sub Cawangan'],
    ];

    public function render()
    {
        $user = Auth::user();
        $team = $user->team->first();
        $spaces = app(Space::class)->getTeamSpaces($team->id);

        $query = Organisation::query()->with(['ministry', 'department', 'segment', 'unit', 'subUnit']);

        // ✅ Filters
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->categoryFilter !== '') {
            $query->where('category', $this->categoryFilter);
        }

        if ($this->ministryFilter) {
            $temp = explode('.', $this->ministryFilter);
            if ($temp[0] === 'm') $query->where('ministry_id', $temp[1]);
        }

        if ($this->departmentFilter) {
            $temp = explode('.', $this->departmentFilter);
            if ($temp[0] === 'd') $query->where('department_id', $temp[1]);
        }

        if ($this->segmentFilter) {
            $temp = explode('.', $this->segmentFilter);
            if ($temp[0] === 's') $query->where('segment_id', $temp[1]);
        }

        if ($this->unitFilter) {
            $temp = explode('.', $this->unitFilter);
            if ($temp[0] === 'u') $query->where('unit_id', $temp[1]);
        }

        if ($this->subUnitFilter) {
            $temp = explode('.', $this->subUnitFilter);
            if ($temp[0] === 'su') $query->where('sub_unit_id', $temp[1]);
        }

        $query->orderBy('created_at', 'desc');
        $organisations = $query->paginate(10);

        return view('livewire.organisation.matrix.matrix-list', [
            'organisations' => $organisations,
            'team' => $team,
            'spaces' => $spaces,
        ]);
    }

    public function updating($property)
    {
        $this->resetPage();
    }

    // ✅ Action Buttons Logic

    public function view($id)
    {
        $this->selectedOrganisation = Organisation::with(['ministry', 'department', 'segment', 'unit', 'subUnit'])->find($id);

        if (!$this->selectedOrganisation) {
            $this->error('Organisation not found.');
            return;
        }
        $this->dispatch('open-view-modal');
    }

    public function edit($id)
    {
        $this->toast()
            ->success('Editing matrix record.')
            ->timeout(3000);
        $this->dispatch('openMatrixEditModal', id: $id);
    }

    public function migrate($id)
    {
        $this->toast()
            ->info('Migrate action triggered.')
            ->timeout(3000);
        $this->dispatch('openMatrixMigrateModal', id: $id);
    }

    public function enable($id)
    {
        $org = Organisation::find($id);

        if ($org) {
            $org->status = 1;
            $org->save();

            $this->toast()
                ->success('Organisation enabled successfully!')
                ->timeout(3000);
        } else {
            $this->toast()
                ->danger('Organisation not found!')
                ->timeout(3000);
        }
    }

    public function disable($id)
    {
        $org = Organisation::find($id);

        if ($org) {
            $org->status = 0;
            $org->save();

            $this->toast()
                ->warning('Organisation disabled successfully!')
                ->timeout(3000);
        } else {
            $this->toast()
                ->danger('Organisation not found!')
                ->timeout(3000);
        }
    }
}
