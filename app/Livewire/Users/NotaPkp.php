<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Helpers\GeneralHelper;
use App\Models\{Team, User, Comment, Ministry, Department, Unit, SubUnit};
class NotaPkp extends Component
{
    use WithPagination;

    public Team $team;
    public User $user;

    // Filters
    public $wikiTypeFilter;
    public $pkpAgentFilter;
    public $daysNumberFilter;
    public $artCategoryFilter;
    public $isChildDataIncluded;

    public $ministryFilter;
    public $departmentFilter;
    public $segmentFilter;
    public $unitFilter;
    public $subUnitFilter;

    // Dropdown data
    public $spaces = [];
    public $wikiTypes = [];
    public $pkpAgents = [];
    public $daysNumbers = [];
    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $sub_units_list = [];
    public $artCategories=[];

    public $commentsCount;

    protected $queryString = [
        'wikiTypeFilter',
        'pkpAgentFilter',
        'daysNumberFilter',
        'artCategoryFilter',
        'isChildDataIncluded',
        'ministryFilter',
        'departmentFilter',
        'segmentFilter',
        'unitFilter',
        'subUnitFilter',
    ];

    public function mount(Team $team, User $user)
    {
        $this->team = $team;
        $this->user = $user;

        // Use helper defaults
        $this->wikiTypeFilter = GeneralHelper::wikiTypeArticle();
        $this->spaces         = app('App\Services\SpaceService')->getTeamSpaces($team->id);
        $this->wikiTypes = array_merge(GeneralHelper::wikiTypes(), ['general']);
        $this->pkpAgents      = $user->getPKPUsers();
        $this->daysNumbers    = GeneralHelper::noOfDaysList();
        $this->ministries_list   = Ministry::whereHas('organisations')->get();
        $this->departments_list  = Department::whereHas('organisations')->get();
        $this->artCategories = GeneralHelper::getWikiCategories();
        $this->units_list =     Unit::whereHas('organisations')->get();
        $this->sub_units_list= SubUnit::whereHas('organisations')->get();
    }

    public function updating($field)
    {
        $this->resetPage(); // Reset pagination on filter change
    }

    public function getCommentsProperty()
    {
        // Start base query
        if ($this->wikiTypeFilter == GeneralHelper::wikiTypeGeneral()) {
            $comments = Comment::where('subject_type', 'App\Models\Comment')
                        ->with('user')
                        ->whereNull('deleted_at');
        } else {
            if ($this->wikiTypeFilter == GeneralHelper::wikiTypeDirectory()) {
                $wikiQuery = app('App\Services\WikiService')->getDirectoriesByRoles($this->user);
            } else {
                $wikiQuery = app('App\Services\WikiService')->getArticles($this->user);
            }

            $comments = Comment::whereExists(function ($query) use ($wikiQuery) {
                            $query->select(DB::raw(1))
                                  ->fromSub($wikiQuery, 'filtered_wikis')
                                  ->whereColumn('comments.subject_id', 'filtered_wikis.id');
                        })
                        ->with('user', 'wiki.organisation.ministry', 'wiki.organisation.department',
                               'wiki.organisation.segment', 'wiki.organisation.unit', 'wiki.organisation.subUnit')
                        ->whereNull('comments.deleted_at');
        }

        // Role-based filters
        if ($this->user->current_role_id == GeneralHelper::userInternalPKPAgent()
            || $this->user->current_role_id == GeneralHelper::userExternalPKPAgent()) {
            $comments->where('comments.user_id', $this->user->id);
        } elseif ($this->pkpAgentFilter) {
            $comments->where('comments.user_id', $this->pkpAgentFilter);
        }

        if ($this->daysNumberFilter) {
            $comments->filterByDateDifference($this->daysNumberFilter);
        }

        // Apply organisation filters only if not "general"
        if ($this->wikiTypeFilter != GeneralHelper::wikiTypeGeneral()) {
            if ($this->ministryFilter) {
                $comments->whereHas('wiki.organisation.ministry', function ($query) {
                    $query->where('organisations.ministry_id', $this->ministryFilter);
                });
            }

            if ($this->departmentFilter) {
                $comments->whereHas('wiki.organisation.department', function ($query) {
                    $query->where('organisations.department_id', $this->departmentFilter);
                });
            }

            if ($this->segmentFilter) {
                $comments->whereHas('wiki.organisation.segment', function ($query) {
                    $query->where('organisations.segment_id', $this->segmentFilter);
                });
            }

            if ($this->unitFilter) {
                $comments->whereHas('wiki.organisation.unit', function ($query) {
                    $query->where('organisations.unit_id', $this->unitFilter);
                });
            }

            if ($this->subUnitFilter) {
                $comments->whereHas('wiki.organisation.subUnit', function ($query) {
                    $query->where('organisations.sub_unit_id', $this->subUnitFilter);
                });
            }
        }

        $this->commentsCount = $comments->count();

        return $comments->orderByDaysSinceUpdated()->paginate(10);
    }
    public function resetFilters()
    {
            $this->wikiTypeFilter = '';
            $this->artCategoryFilter = '';
            $this->pkpAgentFilter = '';
            $this->daysNumberFilter = '';
            $this->isChildDataIncluded = true;
            $this->ministryFilter = '';
            $this->departmentFilter = '';
            $this->segmentFilter = '';
            $this->unitFilter = '';
            $this->subUnitFilter = '';

            $this->resetPage();
    }
    public function render()
    {
        return view('livewire.users.nota-pkp', [
            'comments' => $this->comments,
            'commentsCount' => $this->commentsCount,
        ]);
    }
}
