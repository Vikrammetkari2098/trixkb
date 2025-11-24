<?php

namespace App\Livewire\Organisation\Status;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Status;

class StatusList extends Component
{
    use WithPagination;

    public $statusFilter = null;
    public $quantity = 10;

    public array $headers = [];
    public array $statusOptions = [];

    protected $listeners = ['refresh-status-list' => '$refresh'];

    public function mount()
    {
        // Filter dropdown options
        $this->statusOptions = [
            ['label' => 'Is Default', 'value' => 'default'],
            ['label' => 'Is Private', 'value' => 'private'],
            ['label' => 'Is Public',  'value' => 'public'],
        ];

        // Table headers
        $this->headers = [
            ['index' => 'id', 'label' => '#'],
            ['index' => 'name', 'label' => 'Name'],
            ['index' => 'is_default', 'label' => 'Is Default?'],
            ['index' => 'is_private', 'label' => 'Is Private?'],
            ['index' => 'is_public', 'label' => 'Is Public?'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
public function getRowsProperty()
{
    return Status::query()
        ->when($this->statusFilter === 'default', fn($q) => $q->where('is_default', 1))
        ->when($this->statusFilter === 'private', fn($q) => $q->where('is_private', 1))
        ->when($this->statusFilter === 'public', fn($q) => $q->where('is_public', 1))
        ->paginate($this->quantity);
}


    public function render()
    {
        return view('livewire.organisation.status.status-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'statusOptions' => $this->statusOptions,
        ]);
    }
}
