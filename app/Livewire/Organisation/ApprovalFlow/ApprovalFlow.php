<?php

namespace App\Livewire\Organisation\ApprovalFlow;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ApprovalLevel;
use App\Models\Role;
use App\Models\Status;

class ApprovalFlow extends Component
{
    use WithPagination;

    public $team;
    public $search = '';
    public $statusFilter = '';
    public $quantity = 10;

    public array $sort = [
        'column' => 'order',
        'direction' => 'asc',
    ];

    public array $headers = [];
    public $roles = [];
    public $selectedStatusId = null;
    public $selectedRoles = [];
    public $orderData = [];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-approval-flow-list' => '$refresh'];

    public function mount($team)
    {
        $this->team = $team;

        // Table headers
        $this->headers = [
            ['index' => 'id', 'label' => 'No.'],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true],
            ['index' => 'order', 'label' => 'Order', 'sortable' => true],
            ['index' => 'roles', 'label' => 'Roles'],
            ['index' => 'action', 'label' => 'Actions'],
        ];

        // Roles list
        $this->roles = Role::all();
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingQuantity() { $this->resetPage(); }

    public function sortBy($column)
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] = $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }
    }

    public function loadRoles($statusId)
    {
        $this->selectedStatusId = $statusId;
        $this->selectedRoles = ApprovalLevel::where('status_from_id', $statusId)
            ->pluck('role_id')
            ->toArray();
    }

    public function saveRoles()
    {
        if(!$this->selectedStatusId) return;

        // Delete old roles
        ApprovalLevel::where('status_from_id', $this->selectedStatusId)->delete();

        foreach($this->selectedRoles as $roleId) {
            ApprovalLevel::create([
                'role_id' => $roleId,
                'status_from_id' => $this->selectedStatusId,
                'order' => 1,
                'created_by' => auth()->id(),
                'last_updated_by' => auth()->id(),
            ]);
        }

        $this->selectedStatusId = null;
        $this->selectedRoles = [];
        $this->emit('refresh-approval-flow-list');
        session()->flash('success', 'Roles updated successfully!');
    }

    public function saveOrder()
    {
        if(is_array($this->orderData)){
            foreach($this->orderData as $data){
                ApprovalLevel::where('id', $data['id'])->update([
                    'order' => $data['order'],
                    'last_updated_by' => auth()->id(),
                ]);
            }
        }
        $this->emit('refresh-approval-flow-list');
        session()->flash('success', 'Order saved successfully!');
    }

    public function getRowsProperty()
    {
        return ApprovalLevel::with(['role', 'statusFrom'])
            ->when($this->search, function($query){
                $query->whereHas('statusFrom', fn($q) => $q->where('name','like','%'.$this->search.'%'));
            })
            ->when($this->statusFilter !== '', fn($query) => $query->where('status_from_id', $this->statusFilter))
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        $rows = $this->rows->through(function($item){
            $item->status_name = $item->statusFrom->name ?? '-';
            $item->role_names = $item->role->name ?? '-';
            return $item;
        });

        return view('livewire.organisation.approvalflow.approval-flow', [
            'rows' => $rows,
            'headers' => $this->headers,
        ]);
    }
}
