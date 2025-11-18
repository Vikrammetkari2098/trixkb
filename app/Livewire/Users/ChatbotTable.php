<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Chatbot;
use App\Models\Organisation;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ChatbotsExport;
use App\Models\Ministry;
use App\Models\Department;

class ChatbotTable extends Component
{
    use WithPagination;

    // Filters
    public $ministryFilter = '';
    public $departmentFilter = '';
    public $regionFilter = '';
    public $languageFilter = '';
    public $statusFilter = '';
    public $keySearch = '';
    public $start_date;
    public $end_date;

    // Dropdown lists
    public $ministries = [];
    public $departments = [];
    public $regions = [];
    public $languages = [];
    public $statuses = [];

    public $team;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public function mount($team)
    {
        $this->team = $team;

        $this->ministries = (new Organisation)->getMinistriesForChatbot();
        $this->ministries=Ministry::orderBy('name')->get();
        $this->departments = Department::orderBy('name')->get();
        $this->regions = Chatbot::REGION;
        $this->languages = Chatbot::LANGUAGE;
        $this->statuses = Chatbot::STATUS;
    }

    public function updateFilters($filters)
    {
        $this->ministryFilter = $filters['ministryFilter'] ?? '';
        $this->departmentFilter = $filters['departmentFilter'] ?? '';
        $this->regionFilter = $filters['regionFilter'] ?? '';
        $this->languageFilter = $filters['languageFilter'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? '';
        $this->keySearch = $filters['keySearch'] ?? '';
        $this->start_date = $filters['start_date'] ?? null;
        $this->end_date = $filters['end_date'] ?? null;

        // Update departments dynamically when ministry changes
        $this->departments = $this->ministryFilter
            ? (new Organisation)->getDepartmentForChatbotBasedOnMinistry($this->ministryFilter)
            : [];
    }

    private function queryBuilder()
    {
        return Chatbot::with('user', 'organisation.ministry', 'organisation.department')
            ->when($this->team, fn($q) => $q->where('team_id', $this->team->id))
            ->when($this->ministryFilter, fn($q) => $q->whereHas('organisation.ministry', fn($q) => $q->where('ministry_id', $this->ministryFilter)))
            ->when($this->departmentFilter, fn($q) => $q->whereHas('organisation.department', fn($q) => $q->where('department_id', $this->departmentFilter)))
            ->when($this->regionFilter, fn($q) => $q->where('region', $this->regionFilter))
            ->when($this->languageFilter, fn($q) => $q->where('language_id', $this->languageFilter))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->keySearch, fn($q) => $q->where(function($query){
                $query->where('main_category', 'like', '%'.$this->keySearch.'%')
                      ->orWhere('service', 'like', '%'.$this->keySearch.'%')
                      ->orWhere('sub_service', 'like', '%'.$this->keySearch.'%')
                      ->orWhere('description', 'like', '%'.$this->keySearch.'%')
                      ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%'.$this->keySearch.'%'))
                      ->orWhereHas('organisation', fn($q) => $q->where('name', 'like', '%'.$this->keySearch.'%'));
            }))
            ->when($this->start_date, fn($q) => $q->whereDate('created_at', '>=', $this->start_date))
            ->when($this->end_date, fn($q) => $q->whereDate('created_at', '<=', $this->end_date))
            ->latest();
    }

    public function exportExcel()
    {
        return Excel::download(new ChatbotsExport($this->queryBuilder()->get()), 'chatbots.xlsx');
    }

   public function render()
    {
        $chatbots = $this->queryBuilder()->paginate(5);
        $chatbotCount = $chatbots->total();

        return view('livewire.users.chatbot-table', [
            'chatbots' => $chatbots,
            'chatbotCount' => $chatbotCount,
            'ministries' => $this->ministries,
            'departments' => $this->departments,
            'regions' => $this->regions,
            'languages' => $this->languages,
            'statuses' => $this->statuses,
        ]);
    }
}
