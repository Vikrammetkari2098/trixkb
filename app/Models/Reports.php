<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Reports extends Model
{
        use HasFactory;
    public function getContentCreate($request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedSpace = $request->input('spaces');
        $searchTerm = $request->input('search');
        $categoryFilters = true;
        $department_data = [];
        $segment_data = [];
        $unit_data = [];
        $sub_unit_data = [];

        $wikisCreateQuery = Wiki::join('users', 'wiki.user_id', '=', 'users.id')
            ->join('space', 'wiki.space_id', '=', 'space.id')
            ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
            ->leftJoin('ministry', 'organisations.ministry_id', '=', 'ministry.ministry_id')
            ->leftJoin('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('segment', 'organisations.segment_id', '=', 'segment.segment_id')
            ->leftJoin('unit', 'organisations.unit_id', '=', 'unit.unit_id')
            ->leftJoin('sub_unit', 'organisations.sub_unit_id', '=', 'sub_unit.sub_unit_id')

            ->select(
                'users.name as user_name',
                'space.name as space_name',
                'wiki.name as wiki_name',
                'wiki.wiki_type',
                'wiki.ministry_id',
                'wiki.department_id',
                'wiki.segment_id',
                'wiki.unit_id',
                'wiki.sub_unit_id',
                'wiki.created_at',
                'wiki.updated_at',
                'wiki.deleted_at',
                'wiki.start_date',
                'wiki.end_date',
                'ministry.name as ministry_name',
                'department.name as department_name',
                'segment.name as segment_name',
                'unit.name as unit_name',
                'sub_unit.name as sub_unit_name'
            )
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('wiki.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('wiki.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })
            ->when($selectedSpace && $selectedSpace !== 'all', function ($query) use ($selectedSpace) {
                $query->where('space.id', $selectedSpace);
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('wiki.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('space.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('wiki.name', 'like', '%' . $searchTerm . '%')
                    // Filter language_id directly here

                        ->orWhere('ministry.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('segment.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unit.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sub_unit.name', 'like', '%' . $searchTerm . '%');
                });
            })
            ->when($user->current_role_id == userInternalContentCreator(), function ($query) use ($startDate, $user) {
                $query->where('wiki.created_by', '=', $user->id);
            })
            ->orderBy('wiki.created_at', 'desc');

            $wikisCreateQuery->where('wiki.wiki_type', 'article');

        // Apply additional advanced search filters here
        if ($categoryFilters) {
            // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
            //     $wikisCreateQuery->where('wiki.wiki_type', $_GET['wiki_type']);
            // }

            if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                $ministryId = $_GET['ministry_id'];
                $wikisCreateQuery->whereHas('organisation.ministry', function ($query) use ($ministryId) {
                    $query->where('ministry_id', $ministryId);
                });
                $department_data = $this->getDepartmentsBelongsToMinistry($ministryId);
            }
            // Check if category1, category2, etc., parameters are set and apply filters accordingly
            // dd($_GET['department_id']);

            if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                $departmentId = $_GET['department_id'];
                $wikisCreateQuery->whereHas('organisation.department', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                });
                $segment_data = $this->getSegmentsBelongsToDepartment($departmentId);
            }

            if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                $segmentId = $_GET['segment_id'];
                $wikisCreateQuery->whereHas('organisation.segment', function ($query) use ($segmentId) {
                    $query->where('segment_id', $segmentId);
                });
                $unit_data = $this->getUnitsBelongsToSegment($segmentId);
            }

            if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                $unitId = $_GET['unit_id'];
                $wikisCreateQuery->whereHas('organisation.unit', function ($query) use ($unitId) {
                    $query->where('unit_id', $unitId);
                });
                $sub_unit_data = $this->getSubUnitsBelongsToUnit($unitId);
            }

            if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                $subUnitId = $_GET['sub_unit_id'];
                $wikisCreateQuery->whereHas('organisation.subUnit', function ($query) use ($subUnitId) {
                    $query->where('sub_unit_id', $subUnitId);
                });
            }
        }

        return [
            'wikisCreateQuery' => $wikisCreateQuery,
            'departments' => $department_data,
            'segments' => $segment_data,
            'units' => $unit_data,
            'subUnits' => $sub_unit_data,
        ];

        // return $wikisCreateQuery;
    }

    public function getContentCreate2($request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedSpace = $request->input('spaces');
        $searchTerm = $request->input('search');
        $categoryFilters = true;
        $department_data = [];
        $segment_data = [];
        $unit_data = [];
        $sub_unit_data = [];

        $wikisCreateQuery = Wiki::join('users', 'wiki.user_id', '=', 'users.id')
            ->join('space', 'wiki.space_id', '=', 'space.id')
            ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
            ->leftJoin('ministry', 'organisations.ministry_id', '=', 'ministry.ministry_id')
            ->leftJoin('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('segment', 'organisations.segment_id', '=', 'segment.segment_id')
            ->leftJoin('unit', 'organisations.unit_id', '=', 'unit.unit_id')
            ->leftJoin('sub_unit', 'organisations.sub_unit_id', '=', 'sub_unit.sub_unit_id')

            ->select(
                'users.name as user_name',
                'space.name as space_name',
                'wiki.name as wiki_name',
                'wiki.wiki_type',
                'wiki.ministry_id',
                'wiki.department_id',
                'wiki.segment_id',
                'wiki.unit_id',
                'wiki.sub_unit_id',
                'wiki.created_at',
                'wiki.updated_at',
                'wiki.deleted_at',
                'wiki.start_date',
                'wiki.end_date',
                'ministry.name as ministry_name',
                'department.name as department_name',
                'segment.name as segment_name',
                'unit.name as unit_name',
                'sub_unit.name as sub_unit_name'
            )
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('wiki.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('wiki.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })
            ->when($selectedSpace && $selectedSpace !== 'all', function ($query) use ($selectedSpace) {
                $query->where('space.id', $selectedSpace);
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('wiki.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('space.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('wiki.name', 'like', '%' . $searchTerm . '%')
                    // Filter language_id directly here

                        ->orWhere('ministry.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('segment.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unit.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sub_unit.name', 'like', '%' . $searchTerm . '%');
                });
            })
            ->when($user->current_role_id == userInternalContentCreator(), function ($query) use ($startDate, $user) {
                $query->where('wiki.created_by', '=', $user->id);
            })
            ->orderBy('wiki.created_at', 'desc');

            $wikisCreateQuery->where('wiki.wiki_type', 'directory');

        // Apply additional advanced search filters here
        if ($categoryFilters) {
            // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
            //     $wikisCreateQuery->where('wiki.wiki_type', $_GET['wiki_type']);
            // }

            if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                $ministryId = $_GET['ministry_id'];
                $wikisCreateQuery->whereHas('organisation.ministry', function ($query) use ($ministryId) {
                    $query->where('ministry_id', $ministryId);
                });
                $department_data = $this->getDepartmentsBelongsToMinistry($ministryId);
            }
            // Check if category1, category2, etc., parameters are set and apply filters accordingly
            // dd($_GET['department_id']);

            if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                $departmentId = $_GET['department_id'];
                $wikisCreateQuery->whereHas('organisation.department', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                });
                $segment_data = $this->getSegmentsBelongsToDepartment($departmentId);
            }

            if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                $segmentId = $_GET['segment_id'];
                $wikisCreateQuery->whereHas('organisation.segment', function ($query) use ($segmentId) {
                    $query->where('segment_id', $segmentId);
                });
                $unit_data = $this->getUnitsBelongsToSegment($segmentId);
            }

            if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                $unitId = $_GET['unit_id'];
                $wikisCreateQuery->whereHas('organisation.unit', function ($query) use ($unitId) {
                    $query->where('unit_id', $unitId);
                });
                $sub_unit_data = $this->getSubUnitsBelongsToUnit($unitId);
            }

            if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                $subUnitId = $_GET['sub_unit_id'];
                $wikisCreateQuery->whereHas('organisation.subUnit', function ($query) use ($subUnitId) {
                    $query->where('sub_unit_id', $subUnitId);
                });
            }
        }

        return [
            'wikisCreateQuery' => $wikisCreateQuery,
            'departments' => $department_data,
            'segments' => $segment_data,
            'units' => $unit_data,
            'subUnits' => $sub_unit_data,
        ];

        // return $wikisCreateQuery;
    }

    public function getContentUpdate($request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedSpace = $request->input('spaces');
        $searchTerm = $request->input('search');
        $categoryFilters = true;
        $department_data = [];
        $segment_data = [];
        $unit_data = [];
        $sub_unit_data = [];

        $wikisUpdateQuery = Wiki::join('users', 'wiki.user_id', '=', 'users.id')
            ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
            ->leftJoin('wiki_log', 'wiki.id', '=', 'wiki_log.wiki_id')
            ->leftJoin('users as changed_by_user', 'wiki_log.modified_by', '=', 'changed_by_user.id')
            ->leftJoin('ministry', 'organisations.ministry_id', '=', 'ministry.ministry_id')
            ->leftJoin('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('segment', 'organisations.segment_id', '=', 'segment.segment_id')
            ->leftJoin('unit', 'organisations.unit_id', '=', 'unit.unit_id')
            ->leftJoin('sub_unit', 'organisations.sub_unit_id', '=', 'sub_unit.sub_unit_id')
            ->whereNotNull('wiki_log.wiki_id')
            ->select(
                'users.name as user_name',
                'wiki.name as wiki_name',
                'wiki.wiki_type',
                'changed_by_user.name as changed_by',
                'wiki.created_at',
                'wiki.updated_at',
                'ministry.name as ministry_name',
                'department.name as department_name',
                'segment.name as segment_name',
                'unit.name as unit_name',
                'sub_unit.name as sub_unit_name',
                'wiki_log.updated_at as updated_at'
            )
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('wiki_log.updated_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('wiki_log.updated_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })

            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('wiki.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('changed_by_user.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ministry.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('segment.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unit.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sub_unit.name', 'like', '%' . $searchTerm . '%');
                        // ->orWhere('wiki_status_log.status', 'like', '%' . $searchTerm . '%');
                        // ->orWhere('changed_by', 'like', '%' . $searchTerm . '%');
                });
            })
            // ->when($categoryFilters, function ($query) use ($categoryFilters) {
            //     if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
            //         $query->where('wiki.wiki_type', $_GET['wiki_type']);
            //     }

            //     if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
            //         $query->where('wiki.ministry_id', $_GET['ministry_id']);
            //     }
            //     // Check if category1, category2, etc., parameters are set and apply filters accordingly
            //     // dd($_GET['department_id']);

            //     if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
            //         $query->where('wiki.department_id', $_GET['department_id']);
            //     }
            //     if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
            //         $query->where('wiki.segment_id', $_GET['segment_id']);
            //     }
            //     if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
            //         $query->where('wiki.unit_id', $_GET['unit_id']);
            //     }
            //     if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
            //         $query->where('wiki.sub_unit_id', $_GET['sub_unit_id']);
            //     }
            // })
            ->orderBy('wiki.updated_at', 'desc');

            $wikisUpdateQuery->where('wiki.wiki_type', 'article');

            if ($categoryFilters) {
                // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
                //     $wikisUpdateQuery->where('wiki.wiki_type', $_GET['wiki_type']);
                // }

                if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                    $ministryId = $_GET['ministry_id'];
                    $wikisUpdateQuery->whereHas('organisation.ministry', function ($query) use ($ministryId) {
                        $query->where('ministry_id', $ministryId);
                    });
                    $department_data = $this->getDepartmentsBelongsToMinistry($ministryId);
                }
                // Check if category1, category2, etc., parameters are set and apply filters accordingly
                // dd($_GET['department_id']);

                if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                    $departmentId = $_GET['department_id'];
                    $wikisUpdateQuery->whereHas('organisation.department', function ($query) use ($departmentId) {
                        $query->where('department_id', $departmentId);
                    });
                    $segment_data = $this->getSegmentsBelongsToDepartment($departmentId);
                }

                if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                    $segmentId = $_GET['segment_id'];
                    $wikisUpdateQuery->whereHas('organisation.segment', function ($query) use ($segmentId) {
                        $query->where('segment_id', $segmentId);
                    });
                    $unit_data = $this->getUnitsBelongsToSegment($segmentId);
                }

                if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                    $unitId = $_GET['unit_id'];
                    $wikisUpdateQuery->whereHas('organisation.unit', function ($query) use ($unitId) {
                        $query->where('unit_id', $unitId);
                    });
                    $sub_unit_data = $this->getSubUnitsBelongsToUnit($unitId);
                }

                if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                    $subUnitId = $_GET['sub_unit_id'];
                    $wikisUpdateQuery->whereHas('organisation.subUnit', function ($query) use ($subUnitId) {
                        $query->where('sub_unit_id', $subUnitId);
                    });
                }
            }

            return [
                'wikisUpdateQuery' => $wikisUpdateQuery,
                'departments' => $department_data,
                'segments' => $segment_data,
                'units' => $unit_data,
                'subUnits' => $sub_unit_data,
            ];
    }

    public function getContentUpdate2($request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedSpace = $request->input('spaces');
        $searchTerm = $request->input('search');
        $categoryFilters = true;
        $department_data = [];
        $segment_data = [];
        $unit_data = [];
        $sub_unit_data = [];

        $wikisUpdateQuery = Wiki::join('users', 'wiki.user_id', '=', 'users.id')
            ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
            ->leftJoin('wiki_log', 'wiki.id', '=', 'wiki_log.wiki_id')
            ->leftJoin('users as changed_by_user', 'wiki_log.modified_by', '=', 'changed_by_user.id')
            ->leftJoin('ministry', 'organisations.ministry_id', '=', 'ministry.ministry_id')
            ->leftJoin('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('segment', 'organisations.segment_id', '=', 'segment.segment_id')
            ->leftJoin('unit', 'organisations.unit_id', '=', 'unit.unit_id')
            ->leftJoin('sub_unit', 'organisations.sub_unit_id', '=', 'sub_unit.sub_unit_id')
            ->whereNotNull('wiki_log.wiki_id')
            ->select(
                'users.name as user_name',
                'wiki.name as wiki_name',
                'wiki.wiki_type',
                'changed_by_user.name as changed_by',
                'wiki.created_at',
                'wiki.updated_at',
                'ministry.name as ministry_name',
                'department.name as department_name',
                'segment.name as segment_name',
                'unit.name as unit_name',
                'sub_unit.name as sub_unit_name',
                'wiki_log.updated_at as updated_at'
            )
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('wiki.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('wiki.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })

            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('wiki.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('changed_by_user.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ministry.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('segment.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unit.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sub_unit.name', 'like', '%' . $searchTerm . '%');
                        // ->orWhere('wiki_status_log.status', 'like', '%' . $searchTerm . '%');
                        // ->orWhere('changed_by', 'like', '%' . $searchTerm . '%');
                });
            })
            // ->when($categoryFilters, function ($query) use ($categoryFilters) {
            //     if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
            //         $query->where('wiki.wiki_type', $_GET['wiki_type']);
            //     }

            //     if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
            //         $query->where('wiki.ministry_id', $_GET['ministry_id']);
            //     }
            //     // Check if category1, category2, etc., parameters are set and apply filters accordingly
            //     // dd($_GET['department_id']);

            //     if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
            //         $query->where('wiki.department_id', $_GET['department_id']);
            //     }
            //     if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
            //         $query->where('wiki.segment_id', $_GET['segment_id']);
            //     }
            //     if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
            //         $query->where('wiki.unit_id', $_GET['unit_id']);
            //     }
            //     if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
            //         $query->where('wiki.sub_unit_id', $_GET['sub_unit_id']);
            //     }
            // })
            ->orderBy('wiki.updated_at', 'desc');

            $wikisUpdateQuery->where('wiki.wiki_type', 'directory');

            if ($categoryFilters) {
                // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
                //     $wikisUpdateQuery->where('wiki.wiki_type', $_GET['wiki_type']);
                // }

                if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                    $ministryId = $_GET['ministry_id'];
                    $wikisUpdateQuery->whereHas('organisation.ministry', function ($query) use ($ministryId) {
                        $query->where('ministry_id', $ministryId);
                    });
                    $department_data = $this->getDepartmentsBelongsToMinistry($ministryId);
                }
                // Check if category1, category2, etc., parameters are set and apply filters accordingly
                // dd($_GET['department_id']);

                if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                    $departmentId = $_GET['department_id'];
                    $wikisUpdateQuery->whereHas('organisation.department', function ($query) use ($departmentId) {
                        $query->where('department_id', $departmentId);
                    });
                    $segment_data = $this->getSegmentsBelongsToDepartment($departmentId);
                }

                if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                    $segmentId = $_GET['segment_id'];
                    $wikisUpdateQuery->whereHas('organisation.segment', function ($query) use ($segmentId) {
                        $query->where('segment_id', $segmentId);
                    });
                    $unit_data = $this->getUnitsBelongsToSegment($segmentId);
                }

                if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                    $unitId = $_GET['unit_id'];
                    $wikisUpdateQuery->whereHas('organisation.unit', function ($query) use ($unitId) {
                        $query->where('unit_id', $unitId);
                    });
                    $sub_unit_data = $this->getSubUnitsBelongsToUnit($unitId);
                }

                if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                    $subUnitId = $_GET['sub_unit_id'];
                    $wikisUpdateQuery->whereHas('organisation.subUnit', function ($query) use ($subUnitId) {
                        $query->where('sub_unit_id', $subUnitId);
                    });
                }
            }

            return [
                'wikisUpdateQuery' => $wikisUpdateQuery,
                'departments' => $department_data,
                'segments' => $segment_data,
                'units' => $unit_data,
                'subUnits' => $sub_unit_data,
            ];
    }

    // Content Wiki logs
    public function getContentWikiLogs($request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedSpace = $request->input('spaces');
        $searchTerm = $request->input('search');
        $categoryFilters = true;
        $department_data = [];
        $segment_data = [];
        $unit_data = [];
        $sub_unit_data = [];

        $deleteWiki = DB::table('wiki')
            ->select(
                'wiki.name as wiki_name',
                'wiki.wiki_type',
                'wiki.ministry_id',
                'wiki.department_id',
                'wiki.segment_id',
                'wiki.unit_id',
                'wiki.sub_unit_id',
                'wiki.created_at',
                'wiki.updated_at',
                'wiki.deleted_at',
                'users_deleted.name as deleted_name',
                'users_created.name as created_name',
                'ministry.name as ministry_name',
                'department.name as department_name',
                'segment.name as segment_name',
                'unit.name as unit_name',
                'sub_unit.name as sub_unit_name'
            )
            ->join('users', 'wiki.user_id', '=', 'users.id')
            ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
            ->leftJoin('users as users_deleted', 'users_deleted.id', '=', 'wiki.deleted_by')
            ->leftJoin('users as users_created', 'users_created.id', '=', 'wiki.user_id')
            ->leftJoin('ministry', 'organisations.ministry_id', '=', 'ministry.ministry_id')
            ->leftJoin('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('segment', 'organisations.segment_id', '=', 'segment.segment_id')
            ->leftJoin('unit', 'organisations.unit_id', '=', 'unit.unit_id')
            ->leftJoin('sub_unit', 'organisations.sub_unit_id', '=', 'sub_unit.sub_unit_id')
            ->whereNotNull('wiki.deleted_at')
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('wiki.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('wiki.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('wiki.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users_deleted.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users_created.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ministry.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('segment.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unit.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sub_unit.name', 'like', '%' . $searchTerm . '%');
                });
            })
            ->when($categoryFilters, function ($query) use ($categoryFilters) {
                // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
                //     $query->where('wiki.wiki_type', $_GET['wiki_type']);
                // }

                // if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                //     $query->where('wiki.ministry_id', $_GET['ministry_id']);
                // }
                // // Check if category1, category2, etc., parameters are set and apply filters accordingly
                // // dd($_GET['department_id']);

                // if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                //     $query->where('wiki.department_id', $_GET['department_id']);
                // }
                // if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                //     $query->where('wiki.segment_id', $_GET['segment_id']);
                // }
                // if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                //     $query->where('wiki.unit_id', $_GET['unit_id']);
                // }
                // if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                //     $query->where('wiki.sub_unit_id', $_GET['sub_unit_id']);
                // }
            })
            ->orderBy('wiki.deleted_at', 'desc');

            $deleteWiki->where('wiki.wiki_type', 'article');

            if ($categoryFilters) {
                // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
                //     $deleteWiki->where('wiki.wiki_type', $_GET['wiki_type']);
                // }

                if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                    $ministryId = $_GET['ministry_id'];
                    $deleteWiki->where('ministry.ministry_id', $ministryId);
                    $department_data = $this->getDepartmentsBelongsToMinistry($ministryId);
                }
                // Check if category1, category2, etc., parameters are set and apply filters accordingly
                // dd($_GET['department_id']);

                if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                    $departmentId = $_GET['department_id'];
                    $deleteWiki->where('department.department_id', $departmentId);
                    $segment_data = $this->getSegmentsBelongsToDepartment($departmentId);
                }

                if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                    $segmentId = $_GET['segment_id'];
                    // $deleteWiki->whereHas('organisation.segment', function ($query) use ($segmentId) {
                    //     $query->where('segment_id', $segmentId);
                    // });
                    $deleteWiki->where('segment.segment_id', $segmentId);
                    $unit_data = $this->getUnitsBelongsToSegment($segmentId);
                }

                if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                    $unitId = $_GET['unit_id'];
                    // $deleteWiki->whereHas('organisation.unit', function ($query) use ($unitId) {
                    //     $query->where('unit_id', $unitId);
                    // });
                    $deleteWiki->where('unit.unit_id', $unitId);
                    $sub_unit_data = $this->getSubUnitsBelongsToUnit($unitId);
                }

                if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                    $subUnitId = $_GET['sub_unit_id'];
                    // $deleteWiki->whereHas('organisation.subUnit', function ($query) use ($subUnitId) {
                    //     $query->where('sub_unit_id', $subUnitId);
                    // });
                    $deleteWiki->where('sub_unit.sub_unit_id', $subUnitId);
                }
            }

        // return $deleteWiki;
        return [
            'wikisDeleteQuery' => $deleteWiki,
            'departments' => $department_data,
            'segments' => $segment_data,
            'units' => $unit_data,
            'subUnits' => $sub_unit_data,
        ];
    }

    public function getContentWikiLogs2($request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedSpace = $request->input('spaces');
        $searchTerm = $request->input('search');
        $categoryFilters = true;
        $department_data = [];
        $segment_data = [];
        $unit_data = [];
        $sub_unit_data = [];

        $deleteWiki = DB::table('wiki')
            ->select(
                'wiki.name as wiki_name',
                'wiki.wiki_type',
                'wiki.ministry_id',
                'wiki.department_id',
                'wiki.segment_id',
                'wiki.unit_id',
                'wiki.sub_unit_id',
                'wiki.created_at',
                'wiki.updated_at',
                'wiki.deleted_at',
                'users_deleted.name as deleted_name',
                'users_created.name as created_name',
                'ministry.name as ministry_name',
                'department.name as department_name',
                'segment.name as segment_name',
                'unit.name as unit_name',
                'sub_unit.name as sub_unit_name'
            )
            ->join('users', 'wiki.user_id', '=', 'users.id')
            ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
            ->leftJoin('users as users_deleted', 'users_deleted.id', '=', 'wiki.deleted_by')
            ->leftJoin('users as users_created', 'users_created.id', '=', 'wiki.user_id')
            ->leftJoin('ministry', 'organisations.ministry_id', '=', 'ministry.ministry_id')
            ->leftJoin('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('segment', 'organisations.segment_id', '=', 'segment.segment_id')
            ->leftJoin('unit', 'organisations.unit_id', '=', 'unit.unit_id')
            ->leftJoin('sub_unit', 'organisations.sub_unit_id', '=', 'sub_unit.sub_unit_id')
            ->whereNotNull('wiki.deleted_at')
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('wiki.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('wiki.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('wiki.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users_deleted.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users_created.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('ministry.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('segment.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unit.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('sub_unit.name', 'like', '%' . $searchTerm . '%');
                });
            })
            ->when($categoryFilters, function ($query) use ($categoryFilters) {
                // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
                //     $query->where('wiki.wiki_type', $_GET['wiki_type']);
                // }

                // if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                //     $query->where('wiki.ministry_id', $_GET['ministry_id']);
                // }
                // // Check if category1, category2, etc., parameters are set and apply filters accordingly
                // // dd($_GET['department_id']);

                // if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                //     $query->where('wiki.department_id', $_GET['department_id']);
                // }
                // if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                //     $query->where('wiki.segment_id', $_GET['segment_id']);
                // }
                // if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                //     $query->where('wiki.unit_id', $_GET['unit_id']);
                // }
                // if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                //     $query->where('wiki.sub_unit_id', $_GET['sub_unit_id']);
                // }
            })
            ->orderBy('wiki.deleted_at', 'desc');

            $deleteWiki->where('wiki.wiki_type', 'directory');

            if ($categoryFilters) {
                // if (isset($_GET['wiki_type']) && $_GET['wiki_type'] !== '') {
                //     $deleteWiki->where('wiki.wiki_type', $_GET['wiki_type']);
                // }

                if (isset($_GET['ministry_id']) && $_GET['ministry_id'] != '') {
                    $ministryId = $_GET['ministry_id'];
                    $deleteWiki->where('ministry.ministry_id', $ministryId);
                    $department_data = $this->getDepartmentsBelongsToMinistry($ministryId);
                }
                // Check if category1, category2, etc., parameters are set and apply filters accordingly
                // dd($_GET['department_id']);

                if (isset($_GET['department_id']) && $_GET['department_id'] != '') {
                    $departmentId = $_GET['department_id'];
                    $deleteWiki->where('department.department_id', $departmentId);
                    $segment_data = $this->getSegmentsBelongsToDepartment($departmentId);
                }

                if (isset($_GET['segment_id']) && $_GET['segment_id'] != '') {
                    $segmentId = $_GET['segment_id'];
                    // $deleteWiki->whereHas('organisation.segment', function ($query) use ($segmentId) {
                    //     $query->where('segment_id', $segmentId);
                    // });
                    $deleteWiki->where('segment.segment_id', $segmentId);
                    $unit_data = $this->getUnitsBelongsToSegment($segmentId);
                }

                if (isset($_GET['unit_id']) && $_GET['unit_id'] != '') {
                    $unitId = $_GET['unit_id'];
                    // $deleteWiki->whereHas('organisation.unit', function ($query) use ($unitId) {
                    //     $query->where('unit_id', $unitId);
                    // });
                    $deleteWiki->where('unit.unit_id', $unitId);
                    $sub_unit_data = $this->getSubUnitsBelongsToUnit($unitId);
                }

                if (isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] != '') {
                    $subUnitId = $_GET['sub_unit_id'];
                    // $deleteWiki->whereHas('organisation.subUnit', function ($query) use ($subUnitId) {
                    //     $query->where('sub_unit_id', $subUnitId);
                    // });
                    $deleteWiki->where('sub_unit.sub_unit_id', $subUnitId);
                }
            }

        // return $deleteWiki;
        return [
            'wikisDeleteQuery' => $deleteWiki,
            'departments' => $department_data,
            'segments' => $segment_data,
            'units' => $unit_data,
            'subUnits' => $sub_unit_data,
        ];
    }

    public function getDireCount($request, $wikiType, $year)
    {
        $user = auth()->user();
        if($wikiType == wikiTypeDirectory())
        {
            $result = DB::table('ministry')
            ->leftJoin('organisations', 'ministry.ministry_id', '=', 'organisations.ministry_id')
            ->where('organisations.status', getActiveStatus())
            ->whereYear('organisations.created_at', $year)
            ->join('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('wiki', function($join) use ($user) {
                $join->on('organisations.id', '=', 'wiki.organisation_id')
                    ->where('wiki.wiki_type', '=', wikiTypeDirectory())
                    ->when($user->current_role_id == userInternalContentCreator(), function ($query) use ($user) {
                        $query->where('wiki.created_by', '=', $user->id);
                    })
                    ->whereNull('wiki.deleted_at');
            })
            ->select('ministry.ministry_id', 'ministry.name as ministry_name', 'department.name as department_name', DB::raw('COALESCE(COUNT(wiki.id), 0) as num_wikis'))
            ->groupBy('ministry.ministry_id', 'department.name');
        }

        else{

            $result = DB::table('ministry')
            ->leftJoin('organisations', 'ministry.ministry_id', '=', 'organisations.ministry_id')
            ->where('organisations.status', getActiveStatus())
            ->whereYear('organisations.created_at', $year)
            ->join('department', 'organisations.department_id', '=', 'department.department_id')
            ->leftJoin('wiki', function($join) use ($user) {
                $join->on('organisations.id', '=', 'wiki.organisation_id')
                    ->where('wiki.wiki_type', '=', wikiTypeArticle())
                    ->when($user->current_role_id == userInternalContentCreator(), function ($query) use ($user) {
                        $query->where('wiki.created_by', '=', $user->id);
                    })
                    ->whereNull('wiki.deleted_at');
            })
            ->select('ministry.ministry_id', 'ministry.name as ministry_name', 'department.name as department_name', DB::raw('COALESCE(COUNT(wiki.id), 0) as num_wikis'))
            ->groupBy('ministry.ministry_id', 'department.name');

        }
        $result = $result->orderBy('num_wikis', 'desc')->orderBy('ministry_id');

        return $result;

    }

    public function getDireCountPdf($request){

        // dd($request->type);
        $type = $request->type;
        $batch = $request->input('batch');
        if($type == 'direCount')
        {
            if($batch && $batch != '')
            {
                $results = $this->getDireCount($request, wikiTypeDirectory(), $batch)->get();
            }

            else
            {
                $results = [];
            }

            $formattedResults = [];
            foreach ($results as $result) {
                $ministryKey = array_search($result->ministry_id, array_column($formattedResults, 'ministry_id'));
                if ($ministryKey === false) {
                    $formattedResults[] = [
                        'ministry_id' => $result->ministry_id,
                        'ministry_name' => $result->ministry_name,
                        'departments' => [
                            [
                                'department_name' => $result->department_name,
                                'num_wikis' => $result->num_wikis,
                            ],
                        ],
                    ];
                } else {
                    $formattedResults[$ministryKey]['departments'][] = [
                        'department_name' => $result->department_name,
                        'num_wikis' => $result->num_wikis,
                    ];
                }
            }
        }

        else{
            $results = $this->getDireCount($request, wikiTypeArticle(), $batch)->get();
            $formattedResults = [];
            foreach ($results as $result) {
                $ministryKey = array_search($result->ministry_id, array_column($formattedResults, 'ministry_id'));
                if ($ministryKey === false) {
                    $formattedResults[] = [
                        'ministry_id' => $result->ministry_id,
                        'ministry_name' => $result->ministry_name,
                        'departments' => [
                            [
                                'department_name' => $result->department_name,
                                'num_wikis' => $result->num_wikis,
                            ],
                        ],
                    ];
                } else {
                    $formattedResults[$ministryKey]['departments'][] = [
                        'department_name' => $result->department_name,
                        'num_wikis' => $result->num_wikis,
                    ];
                }
            }

        }

        return $formattedResults;
    }

    public function getDireTransaction(){

        $user = auth()->user();

        $ministries = $user->getMinistries()->get();

        foreach($ministries as $ministry)
        {

            // $createdNoDeptCount = Wiki::where('wiki_type', wikiTypeDirectory())->withTrashed()->whereHas('organisation', function ($query) use ($ministry) {
            //                                 $query->where('ministry_id', $ministry->ministry_id)
            //                                       ->where('category',getOrganisationCategory('Ministry'));
            //                                     })->count();

            // $noDeptWikiIds = Wiki::where('wiki_type', wikiTypeDirectory())->withTrashed()->whereHas('organisation', function ($query) use ($ministry) {
            //                     $query->where('ministry_id', $ministry->ministry_id)
            //                         ->where('category',getOrganisationCategory('Ministry'));
            //                         })->pluck('wiki.id');

            // $updatedNoDeptCount = DB::table('wiki_log')->whereIn('wiki_id', $noDeptWikiIds)->count();

            // $deletedNoDeptCount = Wiki::where('wiki_type', wikiTypeDirectory())->onlyTrashed()
            //                             ->whereHas('organisation', function ($query) use ($ministry) {
            //                                 $query->where('ministry_id', $ministry->ministry_id)
            //                                     ->where('category',getOrganisationCategory('Ministry'));
            //                                     })->count();

            // $bulkUploadNoDeptCount = Wiki::where('wiki_type', wikiTypeDirectory())->whereNotNull('bulk_id')
            //                                 ->whereHas('organisation', function ($query) use ($ministry) {
            //                                     $query->where('ministry_id', $ministry->ministry_id)
            //                                         ->where('category',getOrganisationCategory('Ministry'));
            //                                         })->count();

            $departmentIds = Organisation::where('ministry_id', $ministry->ministry_id)
                                            ->where('category', getOrganisationCategory('Department'))
                                            ->pluck('department_id')
                                            ->toArray();

            $departmentNamesWithCounts = [];
            foreach ($departmentIds as $departmentId) {
                $department = Department::find($departmentId);
                $departmentName = $department->name;

                $createdCount = Wiki::where('wiki_type', wikiTypeDirectory())->withTrashed()->whereHas('organisation', function ($query) use ($ministry, $departmentIds, $departmentId) {
                    $query->where('ministry_id', $ministry->ministry_id)
                          ->where('department_id', $departmentId);
                        })->count();

                // $updatedCount = DB::table('wiki_log')->where('wiki_type', wikiTypeDirectory())
                //                                      ->where('ministry_id', $ministry->ministry_id)
                //                                      ->where('department_id', $departmentId)
                //                                      ->count();

                // $updatedCount = Wiki::where('wiki.wiki_type', wikiTypeDirectory())
                //                     ->leftJoin('wiki_log', 'wiki.id', '=', 'wiki_log.wiki_id')
                //                     ->whereHas('organisation', function ($query) use ($ministry, $departmentIds, $departmentId) {
                //                         $query->where('ministry_id', $ministry->ministry_id)
                //                             ->where('department_id', $departmentId);
                //                             })
                //                     ->whereNotNull('wiki_log.wiki_id')
                //                     ->count();

                $wikiIds = Wiki::where('wiki_type', wikiTypeDirectory())->withTrashed()->whereHas('organisation', function ($query) use ($ministry, $departmentIds, $departmentId) {
                                                        $query->where('ministry_id', $ministry->ministry_id)
                                                            ->where('department_id', $departmentId);
                                                            })->pluck('wiki.id');

                $updatedCount = DB::table('wiki_log')->whereIn('wiki_id', $wikiIds)->count();

                $deletedCount = Wiki::where('wiki_type', wikiTypeDirectory())->onlyTrashed()
                                    ->whereHas('organisation', function ($query) use ($ministry, $departmentIds, $departmentId) {
                                        $query->where('ministry_id', $ministry->ministry_id)
                                            ->where('department_id', $departmentId);
                                            })->count();




                $bulkUploads = DB::table('wiki_upload')
                                 ->join('wiki', 'wiki_upload.bulk_id', '=', 'wiki.bulk_id')
                                 ->join('organisations', 'wiki.organisation_id', '=', 'organisations.id')
                                 ->where('wiki.wiki_type', wikiTypeDirectory())
                                 ->where('organisations.ministry_id', $ministry->ministry_id)
                                 ->where('organisations.department_id', $departmentId)
                                 ->count();

                $departmentNamesWithCounts[$departmentName] = [
                    'created' => $createdCount,
                    'updated' => $updatedCount,
                    'deleted' => $deletedCount,
                    'bulk_uploads' => $bulkUploads,
                ];

            }

            // $wikiNoDeptCount = [
            //     'created' => $createdNoDeptCount,
            //     'updated' => $updatedNoDeptCount,
            //     'deleted' => $deletedNoDeptCount,
            //     'bulk_uploads' => $bulkUploadNoDeptCount,
            // ];

            $ministry->departments = $departmentNamesWithCounts;
            // $ministry->NoDeptWikiCount = $wikiNoDeptCount;
        }
        return $ministries;

    }

    public function getArtAccess($request)
    {
        $ministryId = $request->input('ministry_id');
        $departmentId = $request->input('department_id');
        $segmentId = $request->input('segment_id');
        $unitId = $request->input('unit_id');
        $subUnitId = $request->input('sub_unit_id');
        $artStatus = $request->input('statusId');
        $ccMember = $request->input('member');
        $artName = $request->input('search');
        $formattedResults = [];

        // $statuses = getArticleStatuses();

        $statuses = Status::all();

        $ccMembers = User::join('users_roles', 'users.id', '=', 'users_roles.user_id')
                          ->whereIn('users_roles.role_id', [userInternalContentCreator(), userExternalContentCreator()])
                          ->select('users.id', 'users.name')
                          ->get();

        $years = DB::table('wiki_views')
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderByDesc('year')
                    ->pluck('year');

        $departments = [];
        $segments = [];
        $units = [];
        $subUnits = [];

        $yearFilter = $request->has('year') ? $request->year : null;

        $query = DB::table(DB::raw('(SELECT 1 AS month_number
                              UNION SELECT 2
                              UNION SELECT 3
                              UNION SELECT 4
                              UNION SELECT 5
                              UNION SELECT 6
                              UNION SELECT 7
                              UNION SELECT 8
                              UNION SELECT 9
                              UNION SELECT 10
                              UNION SELECT 11
                              UNION SELECT 12) AS months'))
            ->selectRaw('months.month_number AS month')
            ->selectRaw('COALESCE(SUM(CASE WHEN MONTH(wv.created_at) = months.month_number AND ' . ($ministryId ? "o.ministry_id = $ministryId" : "1=1") . ' AND ' . ($departmentId ? "o.department_id = $departmentId" : "1=1")  . ' AND ' . ($segmentId ? "o.segment_id = $segmentId" : "1=1") . ' AND ' . ($unitId ? "o.unit_id = $unitId" : "1=1") . ' AND ' . ($subUnitId ? "o.sub_unit_id = $subUnitId" : "1=1") . ' AND w.wiki_type = "article" THEN 1 ELSE 0 END), 0) AS total_views')
            ->selectRaw("GROUP_CONCAT(CASE WHEN MONTH(wv.created_at) = months.month_number AND " . ($ministryId ? "o.ministry_id = $ministryId" : "1=1") . ' AND ' . ($departmentId ? "o.department_id = $departmentId" : "1=1")  . ' AND ' . ($segmentId ? "o.segment_id = $segmentId" : "1=1") . ' AND ' . ($unitId ? "o.unit_id = $unitId" : "1=1") . ' AND ' . ($subUnitId ? "o.sub_unit_id = $subUnitId" : "1=1") . " AND w.wiki_type = 'article' THEN wv.wiki_id ELSE NULL END) AS article_wiki_ids")
            ->selectRaw("GROUP_CONCAT(CASE WHEN MONTH(wv.created_at) = months.month_number AND " . ($ministryId ? "o.ministry_id = $ministryId" : "1=1") . " THEN o.ministry_id ELSE NULL END) AS ministry_ids")
            ->leftJoin('wiki_views AS wv', function($join) use ($yearFilter) {
                $join->on(DB::raw('MONTH(wv.created_at)'), '=', 'months.month_number');
                if ($yearFilter) {
                    $join->where(DB::raw('YEAR(wv.created_at)'), '=', $yearFilter);
                }
            })
            ->leftJoin('wiki AS w', function($join) use ($artStatus, $ccMember, $artName){
                $join->on('wv.wiki_id', '=', 'w.id')
                     ->where('w.wiki_type', '=', 'article');
                if($artStatus)
                {
                    $join->where('w.status','=', $artStatus);
                }

                if($ccMember)
                {
                    $join->where('w.created_by','=', $ccMember);
                }

                if ($artName) {
                    $join->where('w.name', 'like', '%' . $artName . '%');
                }
            })
            ->leftJoin('organisations AS o', 'w.organisation_id', '=', 'o.id')
            ->groupBy('months.month_number');

        if($yearFilter)
        {
            $results = $query->get();
        }
        else
        {
            $results = collect();
        }

        if($ministryId)
        {
            $departments = $this->getDepartmentsBelongsToMinistry($ministryId);
        }

        if($departmentId)
        {
            $segments = $this->getSegmentsBelongsToDepartment($departmentId);
        }

        if($segmentId)
        {
            $units = $this->getUnitsBelongsToSegment($segmentId);
        }

        if($unitId)
        {
            $subUnits = $this->getSubUnitsBelongsToUnit($unitId);
        }

        foreach ($results as $accessCount) {
            $monthNumber = $accessCount->month;
            $totalAccesses = $accessCount->total_views;

            $monthName = Carbon::create()->month($monthNumber)->format('F');

            $formattedResults[] = (object)[
                'monthName' => $monthName,
                'total_access' => $totalAccesses,
            ];
        }

        $result = [
            'formattedResults' => $formattedResults,
            'yearList' => $years,
            'yearFilter' => $yearFilter,
            'departments' => $departments,
            'segments' => $segments,
            'units' => $units,
            'subUnits' => $subUnits,
            'statuses' => $statuses,
            'ccMembers' => $ccMembers,
        ];

        return $result;
    }

    public function getArtStatus($request){

        // $years = WikiStatusLog::selectRaw('YEAR(created_at) as year')
        //                       ->distinct()
        //                       ->orderByDesc('year')
        //                       ->pluck('year');

        $formattedResults = [];

        $years = Wiki::selectRaw('YEAR(created_at) as year')
        ->where('wiki_type', '=', WikiTypeArticle())
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

        $yearFilter = $request->has('year') ? $request->year : null;
        // $statusCounts = DB::table(DB::raw('(
        //     SELECT 1 as month
        //     UNION SELECT 2
        //     UNION SELECT 3
        //     UNION SELECT 4
        //     UNION SELECT 5
        //     UNION SELECT 6
        //     UNION SELECT 7
        //     UNION SELECT 8
        //     UNION SELECT 9
        //     UNION SELECT 10
        //     UNION SELECT 11
        //     UNION SELECT 12
        // ) AS months'))
        // ->leftJoin('wiki_status_log', function ($join) use ($yearFilter) {
        //     $join->on(DB::raw('MONTH(wiki_status_log.created_at)'), '=', 'months.month');
        //     if ($yearFilter) {
        //         $join->whereYear('wiki_status_log.created_at', $yearFilter);
        //     }
        // })
        // ->select(
        //     DB::raw('months.month as month'),
        //     DB::raw('COUNT(CASE WHEN wiki_status_log.status = ' . draftStatus() .  ' AND MONTH(wiki_status_log.created_at) = months.month THEN wiki_status_log.id ELSE NULL END) as draft_total'),
        //     DB::raw('COUNT(CASE WHEN wiki_status_log.status = ' . publishStatus() .  ' AND MONTH(wiki_status_log.created_at) = months.month THEN wiki_status_log.id ELSE NULL END) as published_total'),
        //     DB::raw('COUNT(CASE WHEN wiki_status_log.status = ' . expiredStatus() .  ' AND MONTH(wiki_status_log.created_at) = months.month THEN wiki_status_log.id ELSE NULL END) as expired_total'),
        // )
        // ->groupBy(DB::raw('months.month'))
        // ->orderBy(DB::raw('months.month'))
        // ->get();


        if($yearFilter)
        {
            $statusColumns = Status::all()->mapWithKeys(function ($status) {
                $key = str_replace(' ', '_', $status->name) . '_total';
                return [$key => $status->id];
            })->toArray();


            $statusCounts = DB::table(DB::raw('(
                SELECT 1 as month
                UNION SELECT 2
                UNION SELECT 3
                UNION SELECT 4
                UNION SELECT 5
                UNION SELECT 6
                UNION SELECT 7
                UNION SELECT 8
                UNION SELECT 9
                UNION SELECT 10
                UNION SELECT 11
                UNION SELECT 12
            ) AS months'))
            ->leftJoin('wiki', function ($join) use ($yearFilter) {
                $join->on(DB::raw('MONTH(wiki.created_at)'), '=', 'months.month')
                     ->where('wiki_type','=', WikiTypeArticle())
                     ->whereNull('deleted_at');
                if ($yearFilter) {
                    $join->whereYear('wiki.created_at', $yearFilter);
                }
            })
            ->select(
                DB::raw('months.month as month'),
                DB::raw('COUNT(DISTINCT wiki.id) as article_count'),

            );

            foreach ($statusColumns as $alias => $statusId) {
                $statusName = Status::find($statusId)->name;
                $statusCounts->addSelect(
                    DB::raw("COUNT(CASE WHEN wiki.status = $statusId THEN 1 ELSE NULL END) as '$statusName'")
                );
            }

            $statusCounts = $statusCounts->groupBy(DB::raw('months.month'))
            ->orderBy(DB::raw('months.month'))
            ->get();
        }

        else
        {
            $statusCounts = Status::all();
        }


        $result = [
            'statusCounts' => $statusCounts,
            'yearList' => $years,
            'yearFilter' => $yearFilter
        ];

        return $result;

    }

    public function getNotaPKPStatus($request){

        // $years = CommentStatusLog::selectRaw('YEAR(created_at) as year')
        //                       ->distinct()
        //                       ->orderByDesc('year')
        //                       ->pluck('year');

        $years = Comment::selectRaw('YEAR(created_at) as year')
                                ->distinct()
                                ->orderByDesc('year')
                                ->pluck('year');

        $yearFilter = $request->has('year') ? $request->year : null;
        // $statusCounts = DB::table(DB::raw('(
        //     SELECT 1 as month
        //     UNION SELECT 2
        //     UNION SELECT 3
        //     UNION SELECT 4
        //     UNION SELECT 5
        //     UNION SELECT 6
        //     UNION SELECT 7
        //     UNION SELECT 8
        //     UNION SELECT 9
        //     UNION SELECT 10
        //     UNION SELECT 11
        //     UNION SELECT 12
        // ) AS months'))
        // ->leftJoin('comment_status_log', function ($join) use ($yearFilter) {
        //     $join->on(DB::raw('MONTH(comment_status_log.created_at)'), '=', 'months.month');
        //     if ($yearFilter) {
        //         $join->whereYear('comment_status_log.created_at', $yearFilter);
        //     }
        // })
        // ->select(
        //     DB::raw('months.month as month'),
        //     DB::raw("COUNT(CASE WHEN comment_status_log.status = '" . commentToDoStatus() . "' AND MONTH(comment_status_log.created_at) = months.month THEN comment_status_log.id ELSE NULL END) as todo_total"),
        //     DB::raw("COUNT(CASE WHEN comment_status_log.status = '" . commentDoingStatus() . "' AND MONTH(comment_status_log.created_at) = months.month THEN comment_status_log.id ELSE NULL END) as doing_total"),
        //     DB::raw("COUNT(CASE WHEN comment_status_log.status = '" . commentDoneStatus() . "' AND MONTH(comment_status_log.created_at) = months.month THEN comment_status_log.id ELSE NULL END) as done_total")
        // )
        // ->groupBy(DB::raw('months.month'))
        // ->orderBy(DB::raw('months.month'))
        // ->get();

        $statusCounts = DB::table(DB::raw('(
            SELECT 1 as month
            UNION SELECT 2
            UNION SELECT 3
            UNION SELECT 4
            UNION SELECT 5
            UNION SELECT 6
            UNION SELECT 7
            UNION SELECT 8
            UNION SELECT 9
            UNION SELECT 10
            UNION SELECT 11
            UNION SELECT 12
        ) AS months'))
        ->leftJoin('comments', function ($join) use ($yearFilter) {
            $join->on(DB::raw('MONTH(comments.created_at)'), '=', 'months.month')
                ->whereNull('deleted_at');
            if ($yearFilter) {
                $join->whereYear('comments.created_at', $yearFilter);
            }
        })
        ->select(
            DB::raw('months.month as month'),
            DB::raw("COUNT(CASE WHEN comments.status = '" . commentToDoStatusInEn() . "' AND MONTH(comments.created_at) = months.month THEN comments.id ELSE NULL END) as todo_total"),
            DB::raw("COUNT(CASE WHEN comments.status = '" . commentDoingStatusInEn() . "' AND MONTH(comments.created_at) = months.month THEN comments.id ELSE NULL END) as doing_total"),
            DB::raw("COUNT(CASE WHEN comments.status = '" . commentDoneStatusInEn() . "' AND MONTH(comments.created_at) = months.month THEN comments.id ELSE NULL END) as done_total")
        )
        ->groupBy(DB::raw('months.month'))
        ->orderBy(DB::raw('months.month'))
        ->get();

        foreach ($statusCounts as $statusCount) {
            $monthNumber = $statusCount->month;
            $totalToDo = $statusCount->todo_total;
            $totalDoing = $statusCount->doing_total;
            $totalDone =$statusCount->done_total;

            $monthName = Carbon::create()->month($monthNumber)->format('F');

            $formattedResults[] = (object)[
                'monthName' => $monthName,
                'totalToDo' => $totalToDo,
                'totalDoing' => $totalDoing,
                'totalDone' => $totalDone,
            ];
        }

        $result = [
            'formattedResults' => $formattedResults,
            'yearList' => $years,
            'yearFilter' => $yearFilter
        ];

        return $result;

    }

    public function getNotaPKPUsers($request){

        $years = DB::table('comments')
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderByDesc('year')
                    ->pluck('year');

        // $years = DB::table('comment_views')
        //             ->selectRaw('YEAR(created_at) as year')
        //             ->distinct()
        //             ->orderByDesc('year')
        //             ->pluck('year');

        $yearFilter = $request->has('year') ? $request->year : null;

        $userswithComments = User::leftJoin('comments', function($join) use ($yearFilter) {
            $join->on('users.id', '=', 'comments.user_id')
                 ->whereNull('comments.deleted_at');
            if ($yearFilter) {
                $join->whereYear('comments.created_at', $yearFilter);
            }
        })
        ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
        ->whereIn('users_roles.role_id', [userInternalPKPAgent(), userExternalPKPAgent()])
        ->select('users.id', 'users.name', DB::raw('COUNT(comments.id) as comments_count'))
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('comments_count');

        // $userCommentsCount = DB::table('users')
        //                         ->leftJoin('comments', function ($join) use ($yearFilter) {
        //                             $join->on('users.id', '=', 'comments.user_id');
        //                             if ($yearFilter) {
        //                                 $join->whereYear('comments.created_at', $yearFilter);
        //                             }
        //                         })
        //                         ->select('users.id as user_id', 'users.name as user_name', DB::raw('COUNT(comments.id) as comment_count'))
        //                         ->groupBy('users.id', 'users.name')
        //                         ->orderBy('comment_count', 'desc');

        // $usersWithCommentsVisited = User::select('users.id', 'users.name', DB::raw('COUNT(comment_views.comment_id) AS num_comments_visited'))
        //                                 ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
        //                                 ->join('comment_views', 'users.id', '=', 'comment_views.user_id')
        //                                 ->groupBy('users.id', 'users.name')
        //                                 ->orderByDesc('num_comments_visited');
            // dd($usersWithCommentsVisited);

            // $usersWithNotaPKPViews = User::select('users.id', 'users.name', DB::raw('IFNULL(COUNT(comment_views.comment_id), 0) AS num_comments_visited'))
            //                             ->leftJoin('comment_views', function ($join) use ($yearFilter) {
            //                                 $join->on('users.id', '=', 'comment_views.user_id');
            //                                 if ($yearFilter) {
            //                                     $join->whereYear('comment_views.created_at', $yearFilter);
            //                                 }
            //                             })
            //                             ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
            //                             ->groupBy('users.id', 'users.name')
            //                             ->orderByDesc('num_comments_visited');

        $result = [
            'userCommentsCount' => $userswithComments,
            'yearList' => $years,
            'yearFilter' => $yearFilter
        ];

        return $result;
    }

    public function getDireTansactionUsers($request){

        $years = DB::table('wiki')
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderByDesc('year')
                    ->pluck('year');

        $ccMembers = User::join('users_roles', 'users.id', '=', 'users_roles.user_id')
                          ->whereIn('users_roles.role_id', [userInternalContentCreator(), userExternalContentCreator()])
                          ->select('users.id', 'users.name')
                          ->get();

        $ccMemberFilter = $request->has('content_creator') ? $request->content_creator : null;
        $yearFilter = $request->has('year') ? $request->year : null;

        if(!$yearFilter)
        {
            $usersWithRolesAndWikiCount = User::whereRaw('1 = 0');
        }

        else
        {
            $usersWithRolesAndWikiCount = User::select(
                'users.id as user_id',
                'users.name as name',
                DB::raw('COALESCE(w.wiki_count, 0) as num_wikis_created'),
                DB::raw('COALESCE(wl.edit_count, 0) as num_wikis_updated'),
                DB::raw('COALESCE(dw.deleted_wiki_count, 0) as num_wikis_deleted'),
                DB::raw('COALESCE(uw.upload_wiki_count, 0) as num_wikis_uploaded'),
            )
            ->leftJoin(
                DB::raw('(
                            SELECT user_id, COUNT(id) AS wiki_count
                            FROM wiki
                            WHERE wiki_type = "directory"
                                AND bulk_id is NULL
                                AND YEAR(created_at) = '.$yearFilter.'
                            GROUP BY user_id) w'),
                            'users.id', '=', 'w.user_id'
            )
            ->leftJoin(
                DB::raw('(
                            SELECT modified_by, COUNT(id) AS edit_count
                            FROM wiki_log
                            WHERE wiki_type = "directory"
                                AND YEAR(updated_at) = '.$yearFilter.'
                            GROUP BY modified_by) wl'),
                            'users.id', '=', 'wl.modified_by'
            )
            ->leftJoin(
                DB::raw('(
                            SELECT deleted_by, COUNT(id) AS deleted_wiki_count
                            FROM wiki
                            WHERE deleted_at IS NOT NULL
                                AND wiki_type = "directory"
                                AND YEAR(deleted_at) = '.$yearFilter.'
                            GROUP BY deleted_by) dw'),
                            'users.id', '=', 'dw.deleted_by'
            )
            ->leftJoin(
                DB::raw('(
                            SELECT user_id, COUNT(id) AS upload_wiki_count
                            FROM wiki_upload
                            WHERE YEAR(created_at) = '.$yearFilter.'
                            GROUP BY user_id) uw'),
                            'users.id', '=', 'uw.user_id'
            )
            ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->whereIn('users_roles.role_id', [userInternalContentCreator(), userExternalContentCreator()])
            ->when($ccMemberFilter,
                        function ($q) use($ccMemberFilter)
                        {
                            return $q->where('users.id', $ccMemberFilter);
                        }
                    )
            ->orderBy('users.name');
        }

        // if($ccMemberFilter)
        // {
        //     $usersWithRolesAndWikiCount = $usersWithRolesAndWikiCount->where('users.id', $ccMemberFilter);
        // }

        // $usersWithWikisCount = User::leftJoinSub(
        //     'SELECT
        //         created_by,
        //         COUNT(CASE WHEN wiki_type = \'directory\' AND bulk_id IS NULL THEN 1 END) AS create_wikis_count,
        //         COUNT(CASE WHEN wiki_type = \'directory\' AND deleted_at IS NOT NULL THEN 1 END) AS delete_wikis_count,
        //         COUNT(CASE WHEN wiki_type = \'directory\' AND bulk_id IS NOT NULL THEN 1 END) AS upload_wikis_count
        //     FROM wiki
        //     GROUP BY created_by',
        //     'wiki_counts',
        //     function ($join) {
        //         $join->on('users.id', '=', 'wiki_counts.created_by');
        //     }
        // )
        // ->leftJoinSub(
        //     'SELECT
        //         deleted_by,
        //         COUNT(*) as delete_wikis_count
        //     FROM wiki
        //     WHERE wiki_type = \'directory\' AND deleted_at IS NOT NULL
        //     GROUP BY deleted_by',
        //     'deleted_wikis',
        //     function ($join) {
        //         $join->on('users.id', '=', 'deleted_wikis.deleted_by');
        //     }
        // )
        // ->leftJoinSub(
        //     'SELECT
        //         modified_by,
        //         COUNT(*) as wiki_log_count
        //     FROM wiki_log
        //     WHERE wiki_type = \'directory\'
        //     GROUP BY modified_by',
        //     'wiki_logs',
        //     function ($join) {
        //         $join->on('users.id', '=', 'wiki_logs.modified_by');
        //     }
        // )
        // ->select('users.id', 'users.name', 'wiki_counts.create_wikis_count', 'deleted_wikis.delete_wikis_count', 'wiki_logs.wiki_log_count', 'wiki_counts.upload_wikis_count')
        // ->orderBy('users.id');

        $result = [
            'usersWithWikisCount' => $usersWithRolesAndWikiCount,
            'ccMembers' => $ccMembers,
            'ccMemberFilter' => $ccMemberFilter,
            'yearList' => $years,
            'yearFilter' => $yearFilter
        ];
        return $result;
    }

    public function getArticleEntries($request){

        $yearList = DB::table('wiki')
                        ->selectRaw('YEAR(created_at) as year')
                        ->distinct()
                        ->orderByDesc('year')
                        ->pluck('year');

        $year = $request->input('year');
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('role_id', [userInternalContentCreator(), userExternalContentCreator()]);
        })->get();
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $months[$month] = date('F', mktime(0, 0, 0, $month, 1));
        }

        $report = [];

        $totalByMonth = array_fill_keys(array_values($months), 0);

        foreach ($users as $user) {
            $articleCountByMonth = [];

            if ($year) {
                $articles = DB::table('wiki')
                    ->where('wiki_type', wikiTypeArticle())
                    ->whereNull('deleted_at')
                    ->where('created_by', $user->id)
                    ->whereYear('created_at', $year)
                    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->pluck('count', 'month');
            } else {
                // $articles = DB::table('wiki')
                //     ->where('wiki_type', wikiTypeArticle())
                //     ->whereNull('deleted_at')
                //     ->where('created_by', $user->id)
                //     ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
                //     ->groupBy(DB::raw('MONTH(created_at)'))
                //     ->pluck('count', 'month');
                $articles = [];
            }

            $userTotal = 0;

            foreach ($months as $month => $monthName) {
                $count = $articles[$month] ?? 0;
                $articleCountByMonth[$monthName] = $count;
                $totalByMonth[$monthName] += $count;
                $userTotal += $count;
            }

            $report[$user->name] = $articleCountByMonth;
            $report[$user->name]['total'] = $userTotal;
        }

        unset($report['total']);

        return ['report' => $report, 'yearList' => $yearList, 'months' => $months, 'year' => $year];
    }

    public function getLoginStatistics($request)
    {
        $months = getAllMonths();
        $yearList = DB::table('audit_trail')
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'DESC')
                    ->pluck('year');

        $report = [];
        $cumulative = 0;
        foreach ($months as $monthNum => $monthName) {

            if ($request->filled('year')) {
                $countQuery = DB::table('audit_trail')->where('action',loginAction())->whereYear('created_at', $request->year);
            } else {
                $countQuery = DB::table('audit_trail')->where('action',loginAction());
            }
            $count = $countQuery->whereMonth('created_at', $monthNum)->count();
            $cumulative += $count;
            $report[$monthName] = ['monthName' => $monthName, 'count' => $count, 'cumulative' => $cumulative];
        }



        return ['report' => $report, 'yearList' => $yearList, 'months' => $months];

    }

    public function getLoginStatistics2($request, $selectedYear)
    {
        $months = getAllMonths();
        $yearList = DB::table('audit_trail')
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'DESC')
                    ->pluck('year');

        $report = [];
        $cumulative = 0;
        // $year = $request->input('year');

        if ($selectedYear) {
            $logins = DB::table('audit_trail')
                ->select(DB::raw('subject_id, YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as login_count'))
                ->where('action', loginAction())
                ->whereYear('created_at', $selectedYear)
                ->groupBy('subject_id', 'year', 'month')
                ->get();

            foreach ($logins as $login) {
                $loginData[$login->subject_id][$login->year][$login->month] = $login->login_count;
            }
        } else {
            // If no specific year is requested, fetch login statistics for all years
            $logins = DB::table('audit_trail')
                ->select(DB::raw('subject_id, YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as login_count'))
                ->where('action', loginAction())
                ->groupBy('subject_id', 'year', 'month')
                ->get();

            foreach ($logins as $login) {
                $loginData[$login->subject_id][$login->year][$login->month] = $login->login_count;
            }
        }

        return ['loginData' => $loginData, 'yearList' => $yearList];
    }

    public function getAuditTrail($request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $auditTrail = AuditTrail::leftJoin('users as u', 'audit_trail.user_id', '=', 'u.id')
                                ->leftJoin('wiki as w', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'w.id')
                                        ->where('audit_trail.subject', '=', 'Wiki');
                                })
                                ->leftJoin('comments as c', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'c.id')
                                        ->where('audit_trail.subject', '=', 'Comment');
                                })
                                ->leftJoin('users as su', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'su.id')
                                        ->where('audit_trail.subject', '=', 'User');
                                })
                                ->leftJoin('wiki_upload as wu', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'wu.id')
                                        ->where('audit_trail.subject', '=', 'Bulk Upload');
                                })
                                ->leftJoin('wiki_upload as wup', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'wup.id')
                                        ->where('audit_trail.subject', '=', 'Bulk Update');
                                })
                                ->leftJoin('ministry as mi', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'mi.ministry_id')
                                        ->where('audit_trail.subject', '=', 'Ministry');
                                })
                                ->leftJoin('department as dp', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'dp.department_id')
                                        ->where('audit_trail.subject', '=', 'Department');
                                })
                                ->leftJoin('segment as sg', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'sg.segment_id')
                                        ->where('audit_trail.subject', '=', 'Segment');
                                })
                                ->leftJoin('unit as un', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'un.unit_id')
                                        ->where('audit_trail.subject', '=', 'Unit');
                                })
                                ->leftJoin('sub_unit as sub', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'sub.sub_unit_id')
                                        ->where('audit_trail.subject', '=', 'Sub Unit');
                                })
                                ->leftJoin('wiki_chatbot as cb', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'cb.id')
                                        ->where('audit_trail.subject', '=', 'Chatbot');
                                })
                                ->leftJoin('organisations as og', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'og.id')
                                        ->where('audit_trail.subject', '=', 'Organisation');
                                })
                                ->leftJoin('roles as ro', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'ro.id')
                                        ->where('audit_trail.subject', '=', 'Role');
                                })
                                ->leftJoin('case_categories as cc', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'cc.id')
                                        ->where('audit_trail.subject', '=', 'Case Category');
                                })
                                ->leftJoin('sub_case_categories_1 as scc1', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'scc1.id')
                                        ->where('audit_trail.subject', '=', 'Sub Case Category 1');
                                })
                                ->leftJoin('sub_case_categories_2 as scc2', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'scc2.id')
                                        ->where('audit_trail.subject', '=', 'Sub Case Category 2');
                                })
                                ->leftJoin('category_matrices as cm', function($join) {
                                    $join->on('audit_trail.subject_id', '=', 'cm.id')
                                        ->where('audit_trail.subject', '=', 'Category Organisation');
                                })
                                ->select(
                                    'audit_trail.*',
                                    'u.name as user_name',
                                    DB::raw('COALESCE(w.name, c.title, su.name, wu.filename, wup.filename, mi.name, dp.name, sg.name, un.name, sub.name, cb.main_category, og.name, ro.name, cc.name, scc1.name, scc2.name, cm.name) as subject_name')
                                )
                                ->when($startDate, function ($query) use ($startDate) {
                                    $query->where('audit_trail.created_at', '>=', $startDate);
                                })
                                ->when($endDate, function ($query) use ($endDate) {
                                    $query->where('audit_trail.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
                                })
                                    ->orderBy('audit_trail.created_at', 'desc');

        if($request->filled('subject'))
        {
            if($request->input('subject') == userSubject())
            {
                $auditTrail->where('audit_trail.subject', '=', userSubject());
            }

            else if($request->input('subject') == commentSubject())
            {
                $auditTrail->where('audit_trail.subject', '=', commentDataSubject());
            }

            else if($request->input('subject') == wikiSubject()){
                $auditTrail->where('audit_trail.subject', '=', wikiSubject());
            }

            else if($request->input('subject') == ministrySubject()){
                $auditTrail->where('audit_trail.subject', '=', ministrySubject());
            }

            else if($request->input('subject') == departmentSubject()){
                $auditTrail->where('audit_trail.subject', '=', departmentSubject());
            }

            else if($request->input('subject') == segmentSubject()){
                $auditTrail->where('audit_trail.subject', '=', segmentSubject());
            }

            else if($request->input('subject') == unitSubject()){
                $auditTrail->where('audit_trail.subject', '=', unitSubject());
            }

            else if($request->input('subject') == subUnitSubject()){
                $auditTrail->where('audit_trail.subject', '=', subUnitSubject());
            }

            else if($request->input('subject') == chatbotSubject()){
                $auditTrail->where('audit_trail.subject', '=', chatbotSubject());
            }

            else if($request->input('subject') == organisationSubject()){
                $auditTrail->where('audit_trail.subject', '=', organisationSubject());
            }

            else if($request->input('subject') == roleSubject()){
                $auditTrail->where('audit_trail.subject', '=', roleSubject());
            }

            else if($request->input('subject') == caseCategorySubject()){
                $auditTrail->where('audit_trail.subject', '=', caseCategorySubject());
            }

            else if($request->input('subject') == subCaseCategory1Subject()){
                $auditTrail->where('audit_trail.subject', '=', subCaseCategory1Subject());
            }

            else if($request->input('subject') == subCaseCategory2Subject()){
                $auditTrail->where('audit_trail.subject', '=', subCaseCategory2Subject());
            }

            else if($request->input('subject') == categoryOrganisationSubject()){
                $auditTrail->where('audit_trail.subject', '=', categoryOrganisationSubject());
            }
        }

        if($request->filled('action'))
        {
            if($request->input('action') == loginAction())
            {
                $auditTrail->where('audit_trail.action', '=', loginAction());
            }

            else if($request->input('action') == createAction())
            {
                $auditTrail->where('audit_trail.action', '=', createAction());
            }

            else if($request->input('action') == updateAction())
            {
                $auditTrail->where('audit_trail.action', '=', updateAction());
            }

            else if($request->input('action') == deleteAction())
            {
                $auditTrail->where('audit_trail.action', '=', deleteAction());
            }

            else if($request->input('action') == 'bulk upload')
            {
                $auditTrail->where('audit_trail.action', '=', DirectoryUploadAction());
            }

            else if($request->input('action') == 'bulk update')
            {
                $auditTrail->where('audit_trail.action', '=', DirectoryUpdateAction());
            }

            else if($request->input('action') == statusUpdateAction())
            {
                $auditTrail->where('audit_trail.action', '=', statusUpdateAction());
            }

            else if($request->input('action') == viewChatbot())
            {
                $auditTrail->where('audit_trail.action', '=', viewChatbot());
            }

            else if($request->input('action') == favouriteAction())
            {
                $auditTrail->where('audit_trail.action', '=', favouriteAction());
            }

            else if($request->input('action') == unfavouriteAction())
            {
                $auditTrail->where('audit_trail.action', '=', unfavouriteAction());
            }

            else if($request->input('action') == readlistAction())
            {
                $auditTrail->where('audit_trail.action', '=', readlistAction());
            }

            else if($request->input('action') == unreadlistAction())
            {
                $auditTrail->where('audit_trail.action', '=', unreadlistAction());
            }

            else if($request->input('action') == bulkEnabledAction())
            {
                $auditTrail->where('audit_trail.action', '=', bulkEnabledAction());
            }

            else if($request->input('action') == bulkDisabledAction())
            {
                $auditTrail->where('audit_trail.action', '=', bulkDisabledAction());
            }

            else if($request->input('action') == migrateAction())
            {
                $auditTrail->where('audit_trail.action', '=', migrateAction());
            }

            else if($request->input('action') == changePasswordAction())
            {
                $auditTrail->where('audit_trail.action', '=', changePasswordAction());
            }

            else if($request->input('action') == sendResetLinkAction())
            {
                $auditTrail->where('audit_trail.action', '=', sendResetLinkAction());
            }

            else if($request->input('action') == resetPasswordAction())
            {
                $auditTrail->where('audit_trail.action', '=', resetPasswordAction());
            }

            else
            {
                $auditTrail->where('audit_trail.action', '=', viewArticleAction())
                           ->orWhere('audit_trail.action', '=', viewDirectoryAction());
            }
        }

        if($request->filled('user_id'))
        {
            $auditTrail->where('audit_trail.user_id', $request->input('user_id'));
        }

        if($request->input('action') == 'view article' || $request->input('action') == 'view directory')
        {
            $auditTrail = AuditTrail::where('audit_trail.action', $request->input('action'))
            ->leftJoin('users as u', 'audit_trail.user_id', '=', 'u.id')
            ->leftJoin('users as su', function($join) {
                $join->on('audit_trail.subject_id', '=', 'su.id')
                    ->where('audit_trail.subject', '=', 'User');
            })
            ->leftJoin('wiki as w', function($join) {
                $join->on('audit_trail.subject_id', '=', 'w.id')
                    ->where('audit_trail.subject', '=', 'Wiki');
            })
            ->select(
                'audit_trail.*',
                'u.name as user_name',
                DB::raw('COALESCE(w.name, su.name) as subject_name')
            )
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('audit_trail.created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('audit_trail.created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
            })
                ->orderBy('audit_trail.created_at', 'desc');

            if ($request->filled('user_id')) {
                $auditTrail->where('audit_trail.user_id', $request->input('user_id'));
            }
            if ($request->filled('article_id')) {
                $auditTrail->where('audit_trail.subject_id', $request->input('article_id'));
            }
            if ($request->filled('directory_id')) {
                $auditTrail->where('audit_trail.subject_id', $request->input('directory_id'));
            }
            if ($request->filled('search')) {
                $auditTrail->where('ip_address', 'LIKE', '%' . $request->input('search') . '%');
            }

        }

        if($request->filled('search'))
        {
            $auditTrail->where('ip_address', 'LIKE', '%' . $request->input('search') . '%');
        }

        return $auditTrail;
    }

    public function getWikiesbyMinistry($ministryId, $wikiType)
    {
        $organisationIds = Organisation::where('ministry_id', $ministryId)->pluck('id');

        $wikiCount = Wiki::where('wiki_type', $wikiType)->whereIn('organisation_id', $organisationIds)->count();

        return $wikiCount;
    }

    public function todayCreatedArticles()
    {
        $todayCreatedWikiCount = Wiki::where('wiki_type', wikiTypeArticle())
                                     ->whereDate('created_at', today())
                                     ->count();
        return $todayCreatedWikiCount;
    }

    public function currentWeekCreatedArticles()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();
        $currentWeekCreatedArticlesCount = Wiki::where('wiki_type', wikiTypeArticle())
                                                ->whereDate('created_at', '>=', $sevenDaysAgo)
                                                ->count();

        return $currentWeekCreatedArticlesCount;
    }

    public function articleViewsInAWeek()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();

        $count = DB::table('wiki_views')
                    ->select('wiki_views.*')
                    ->whereDate('wiki_views.created_at', '>=', $sevenDaysAgo)
                    ->join('wiki', 'wiki_views.wiki_id', '=', 'wiki.id')
                    ->where('wiki.wiki_type', wikiTypeArticle())
                    ->count();

        return $count;
    }

    public function commentsRecordedInAWeek()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();

        $count = Comment::whereDate('created_at', '>=', $sevenDaysAgo)
                        ->count();

        return $count;
    }

    public function getTodayBulkUploads()
    {
        $total = 0;
        $uploadCounts = DB::table('wiki_upload')->whereDate('created_at', today())
                                                ->pluck('insert_success_count');

            foreach($uploadCounts as $uploadCount)
            {
                $total = $total + $uploadCount;
            }

        return $total;
    }

    public function currentWeekUserRegistration()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();

        $count = User::whereDate('created_at', '>=', $sevenDaysAgo)
                        ->count();

        return $count;
    }

    public function getDepartmentsBelongsToMinistry($ministryId, $wikiType = null)
    {

        $departments = Department::whereIn('department_id', function ($query) use ($ministryId)
        {
            $query->select('department_id')
                ->from('organisations')
                ->where('status', 1)
                ->where('ministry_id', $ministryId)
                ->whereNotNull('department_id');
        })->get();

        return $departments;
    }

    public function getSegmentsBelongsToDepartment($departmentId)
    {
        $segments = Segment::whereIn('segment_id', function ($query) use ($departmentId)
         {
            $query->select('segment_id')
                  ->from('organisations')
                  ->where('status', 1)
                  ->where('department_id', $departmentId)
                  ->whereNotNull('segment_id');
        })->get();
        return $segments;
    }

    public function getUnitsBelongsToSegment($segmentId){
        $units = Unit::whereIn('unit_id', function ($query) use ($segmentId)
         {
            $query->select('unit_id')
                  ->from('organisations')
                  ->where('status', 1)
                  ->where('segment_id', $segmentId)
                  ->whereNotNull('unit_id');
        })->get();
        return $units;
    }

    public function getSubUnitsBelongsToUnit($unitId){
        $subUnits = SubUnit::whereIn('sub_unit_id', function ($query) use ($unitId)
         {
            $query->select('sub_unit_id')
                  ->from('organisations')
                  ->where('status', 1)
                  ->where('unit_id', $unitId)
                  ->whereNotNull('sub_unit_id');
        })->get();
        return $subUnits;
    }

    public function getOrganisationBatch()
    {
        $years = Organisation::select(DB::raw('YEAR(created_at) as year'))
                             ->groupBy(DB::raw('YEAR(created_at)'))
                             ->pluck('year');

        return $years;
    }

}
