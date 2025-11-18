<?php

namespace App\Livewire\Members;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class MembersList extends Component
{
    use WithPagination;

    public ?int $quantity = 5;
    public ?string $search = null;
    public string $activeRole = '';
    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-members-list' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedQuantity()
    {
        $this->resetPage();
    }
    public function getStatusText($status)
    {
        return ($status === 1 || $status === '1' || $status === 'Active') ? 'Active' : 'Inactive';
    }

    public function setRoleFilter($role)
    {
        $this->activeRole = $role;
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] = $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }
        $this->resetPage();
    }
    public function getRowsProperty()
    {
        return User::query()
            ->when($this->search, fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->when($this->activeRole, fn($query) =>
                $query->whereHas('roles', fn($q) => $q->where('name', $this->activeRole))
            )
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    // Role badge colors
    public function getRoleColor($role)
    {
        return match($role) {
            'Admin' => 'bg-purple-100 text-purple-800',
            'Super Admin' => 'bg-indigo-100 text-indigo-800',
            'Editor' => 'bg-green-100 text-green-800',
            'Viewer' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    public function getStatusColor($status)
    {
        return $status === 'Active' ? 'text-green-500' : 'text-red-500';
    }
    public function getRoleCount($roleName)
    {
        return User::whereHas('roles', fn($q) => $q->where('name', $roleName))->count();
    }

    public function render()
    {
        return view('livewire.members.members-list', [
            'rows' => $this->rows,
        ]);
    }
}
