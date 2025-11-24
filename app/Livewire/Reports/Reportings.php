<?php

namespace App\Livewire\Reports;

use App\Helpers\GeneralHelper;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Team;
use App\Models\Wiki;
use App\Models\Space;
use App\Models\ReadList;
use App\Models\Reports;
use App\Models\Status;

class Reportings extends Component
{
    use WithPagination;

    public $team, $user;
    public $type = null, $search, $start_date, $end_date, $batch;
    public $subject, $action, $user_id, $article_id, $directory_id, $searchIP;
    public $year;
    public $subTabs = [];

    protected $paginationTheme = 'bootstrap';

    public function mount(Team $team, User $user)
    {
        $this->team = $team;
        $this->user = $user;

        if(!$this->type) {
            $type = auth()->user()->current_role_id != GeneralHelper::userInternalContentCreator()
                ? 'general-report'
                : 'direCount';

        }
    }

    public function updating($field)
    {
        // reset pagination on search/filter update
        $this->resetPage();
    }

    public function render()
    {
        $reports = new Reports();
        $space = new Space();
        $wiki = new Wiki();
        $user = new User();
        $readList = new ReadList();

        $spaces = $space->getTeamSpaces($this->team->id);
        $perPage = 15;
        $viewPath = '';

        /**
         * 🔥 EXACT SAME LOGIC FROM CONTROLLER (NO SKIPPING)
         */
        switch ($this->type) {
            case 'activity':
                $data = $reports->getContentUpdate(request());
                $results = $data["wikisUpdateQuery"]->paginate($perPage);
                $viewPath = 'reports.content-update';
                break;

            case 'activity2':
                $data = $reports->getContentUpdate2(request());
                $results = $data["wikisUpdateQuery"]->paginate($perPage);
                $viewPath = 'reports.content-update';
                break;

            case 'logs-wikis':
                $data = $reports->getContentWikiLogs(request());
                $results = $data["wikisDeleteQuery"]->paginate($perPage);
                $viewPath = 'reports.content-wiki-audit-logs';
                break;

            case 'logs-wikis2':
                $data = $reports->getContentWikiLogs2(request());
                $results = $data["wikisDeleteQuery"]->paginate($perPage);
                $viewPath = 'reports.content-wiki-audit-logs';
                break;

            case 'direCount':
                $results = $this->batch
                    ? $reports->getDireCount(request(), wikiTypeDirectory(), $this->batch)->get()
                    : [];
                $viewPath = 'reports.content-dire-count';
                break;

            case 'artCount':
                $results = $this->batch
                    ? $reports->getDireCount(request(), wikiTypeArticle(), $this->batch)->get()
                    : [];
                $viewPath = 'reports.content-art-count';
                break;

            case 'directory-transaction':
                $results = $reports->getDireTransaction();
                $viewPath = 'reports.dire-transaction';
                break;

            case 'article-access':
                $results = $reports->getArtAccess(request());
                $viewPath = 'reports.article-access';
                break;

            case 'article-status':
                $results = $reports->getArtStatus(request());
                $viewPath = 'reports.article-status';
                break;

            case 'notaPKP-status':
                $results = GeneralHelper::getNotaPKPStatus(request());
                $viewPath = 'reports.notaPKP-status';
                break;

            case 'notaPKP-users':
                $results = $reports->getNotaPKPUsers(request());
                $results["userCommentsCount"] = $results["userCommentsCount"]->paginate($perPage);
                $viewPath = 'reports.notaPKP-users';
                break;

            case 'directory-transaction-2':
                $results = $reports->getDireTansactionUsers(request());
                $results['usersWithWikisCount'] = $results["usersWithWikisCount"]->paginate($perPage);
                $viewPath = 'reports.directory-transaction-2';
                break;

            case 'article-entries':
                $data = $reports->getArticleEntries(request());
                return view('livewire.reports', [
                    'articleEntries' => collect($data['report'])->sortByDesc('total')->toArray(),
                    'months' => $data['months'],
                    'year' => $data['year'],
                    'yearList' => $data['yearList'],
                    'spaces' => $spaces,
                    'viewPath' => 'reports.article-entries',
                    'team' => $this->team
                ]);

            case 'login-statistics':
                $data = $reports->getLoginStatistics2(request(), $this->year);
                return view('livewire.reports', [
                    'results' => $data,
                    'users' => $this->year ? User::whereHas('roles')->get() : [],
                    'yearList' => $data['yearList'],
                    'loginData' => $data['loginData'],
                    'selectedYear' => $this->year,
                    'spaces' => $spaces,
                    'viewPath' => 'reports.login-statistics',
                    'team' => $this->team
                ]);

            case 'auditTrail':
                $query = $reports->getAuditTrail(request());
                $results = $query->paginate($perPage);
                $viewPath = 'reports.audit-trail';
                break;

            case 'general-report':
                $spaces = $space->getTeamSpaces($this->team->id);
                $notaPKPCounts = GeneralHelper::getNotaPKPStatuses();
                $articleStatusCount = GeneralHelper::getArticleStatuses();
                $ministries = $user->getMinistries()->get();
                return view('livewire.reports', compact(
                   'team', 'spaces', 'notaPKPCounts', 'articleStatusCount', 'ministries'
                ))->with([
                   'viewPath' => 'reports.general-report',
                ]);

            default:
                $data = $reports->getContentCreate(request());
                $results = $data["wikisCreateQuery"]->paginate($perPage);
               $viewPath = 'livewire.reports.content-create';
                break;
        }

        return view('livewire.reports.reportings', [
            'results' => $results,
            'viewPath' => $viewPath,
            'team' => $this->team,
            'spaces' => $spaces,
        ]);
    }
}
