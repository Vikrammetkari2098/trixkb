<div class="report-tab-pane" id="wiki-activity">
    <div class="row no-container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form action="{{ route('reports.reportings', [$team->slug, Auth::user()->slug]) }}" method="GET">
                <input type="hidden" name="type" value="{{ $_GET['type'] ?? 'activity' }}" />
                </br>
                <div class="clearfix"></div>
                <!-- Date range filter -->
                <div class="form-row">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" class="form-control" value="{{ isset($_GET['start_date']) ? $_GET['start_date'] : '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" class="form-control" value="{{ isset($_GET['end_date']) ? $_GET['end_date'] : '' }}">
                        </div>
                        <!-- <div class="col-md-1">
                            <label for="generate_report">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Enter</button>
                        </div> -->
                        <div class="col-md-4">
                            <label for="search">&nbsp;</label>
                            <input type="text" name="search" class="form-control" placeholder="Search Users,Wikis,Ministry,Jabatan,Division,Unit and Sub Unit" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                        </div>
                        <div class="col-md-1">
                            <label for="search_btn">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="small-font">Search</span>
                            </button>
                        </div>
                        <div class="col-md-12">
                                <label>
                                <input type="checkbox" name="wikiIds[]" class="wikiIdCheckbox" form="wikiStatusForm" onchange="handleCheckboxChanges(this)" />
                                    Enable Advanced Search
                                </label>
                        </div>
                        @if(isset($categoryFilters))
                            <div class="form-row side-menu-wiki-list custom-wiki-form" id="advancedSearchForms" style="display: none;">
                                <form method="GET">
                                    @php
                                        // Retrieve 'type' from the query parameters
                                        $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
                                    @endphp
                                    <input type="hidden" name="status" value="{{ isset($_GET['status']) ? $_GET['status'] : '' }}">
                                    <input id="form_wiki_type" name="form_wiki_type" type="hidden" value="edit" />
                                    <input id="reportTypeId" name="report_type" type="hidden" value="{{request()->query('type')}}" />
                                    <ul class="list-unstyled" id="categories-list">
                                        <div class="col-md-4">
                                            <li class="nav-header">
                                                <label style="font-size:12px">Type</label>
                                                <select class="form-control" name="wiki_type" style="height:24px;padding:0px;font-weight:initial;width:100%;">
                                                    <option value="">select</option>
                                                    @foreach($wiki_Type as $type)
                                                        <option value="{{ $type }}" @if(isset($_GET['wiki_type']) && $_GET['wiki_type'] == $type) selected="selected" @endif>{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </div>
                                        <div class="col-md-4">
                                            <li class="nav-header">
                                                <label style="font-size:12px">Ministry</label>
                                                <select class="form-control select2-common firstLvlCascading" name="ministry_id"  style="height:24px;padding:0px;font-weight:initial;width:100%;">
                                                    <option value="">Select Ministry</option>
                                                    @foreach($ministries as $row)
                                                    <option value="{{$row->ministry_id}}" @if(isset($_GET['ministry_id']) && $_GET['ministry_id'] == $row->ministry_id) selected="selected" @endif>{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </div>
                                        <div class="col-md-4">
                                            <li class="nav-header">
                                                <label style="font-size:12px">Department</label>
                                                <select class="form-control select2-common secondLvlCascading" name="department_id"  style="height:24px;padding:0px;font-weight:initial;width:100%;" id="department_filter_id">
                                                    <option value="">Select Department</option>
                                                    @foreach($departments as $row)
                                                    <option value="{{$row->department_id}}" @if(isset($_GET['department_id']) && $_GET['department_id'] == $row->department_id) selected="selected" @endif>{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </div>

                                        <div class="col-md-4">
                                            <li class="nav-header">
                                                <label style="font-size:12px">Division</label>
                                                <select class="form-control select2-common thirdLvlCascading" name="segment_id"  style="height:24px;padding:0px;font-weight:initial;width:100%;" id="segment_filter_id">
                                                    <option value="">Select Division</option>
                                                    @foreach($segments as $row)
                                                    <option value="{{$row->segment_id}}" @if(isset($_GET['segment_id']) && $_GET['segment_id'] == $row->segment_id) selected="selected" @endif>{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </div>

                                        <div class="col-md-4">
                                            <li class="nav-header">
                                                <label style="font-size:12px">Unit/Section/Cawangan</label>
                                                <select class="form-control select2-common forthLvlCascading" name="unit_id"  style="height:24px;padding:0px;font-weight:initial;width:100%;" id="unit_filter_id">
                                                    <option value="">Select Unit/Section/Cawangan</option>
                                                    @foreach($units as $row)
                                                    <option value="{{$row->unit_id}}" @if(isset($_GET['unit_id']) && $_GET['unit_id'] == $row->unit_id) selected="selected" @endif>{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </div>

                                        <div class="col-md-4">
                                            <li class="nav-header">
                                                <label style="font-size:12px">Sub Unit/Sub Section</label>
                                                <select class="form-control select2-common" name="sub_unit_id"  style="height:24px;padding:0px;font-weight:initial;width:100%;" id="sub_unit_filter_id">
                                                    <option value="">Select Sub Unit/Sub Section</option>
                                                    @foreach($subUnits as $row)
                                                    <option value="{{$row->sub_unit_id}}" @if(isset($_GET['sub_unit_id']) && $_GET['sub_unit_id'] == $row->sub_unit_id) selected="selected" @endif>{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </div>

                                    <div class="col-md-4" style="padding-top:13px;">
                                        <li class="nav-header">
                                            <!-- <input type="submit" class="btn btn-success pull-right" style="width:50%"> -->
                                            <button type="button" class="btn btn-secondary" id="clearButton" style="width:50%;background-color:green;color:white" onclick="clearAdvancedSearchs()">
                                                <span class="small-font">Clear</span>
                                            </button>
                                        </li>
                                    </div>
                                    </ul>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                </br>
                <div class="form-row">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" data-type="activity" data-href="{{ route('reports.contentUpdate.doc', [$team->slug, Auth::user()->slug]) }}" class="btn btn-success report-pdp-download-link">
                                <span class="small-text">Download as Word</span>
                            </button>
                            <button type="button" data-type="activity" data-href="{{ route('reports.contentUpdate.pdf', [$team->slug, Auth::user()->slug]) }}" class="btn btn-success report-pdp-download-link">
                                <span class="small-text">Download as PDF</span>
                            </button>
                            <button type="button" data-type="activity" data-href="{{ route('reports.excel.download', [$team->slug, Auth::user()->slug]) }}" class="btn btn-success report-pdp-download-link">
                                <span class="small-text">Download as Excel</span>
                            </button>
                        </div>
                    </div>
                </div>
                </br>
            </form>
        </div>
        </br>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>No</th>
                      <th>User</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Ministry</th>
                      <th>Department</th>
                      <th>Division</th>
                      <th>Unit/Section/Cawangan</th>
                      <th>Sub Unit/Sub Section</th>
                      <th>Created Date</th>
                      <th>Update Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $i = (($currentPage - 1) * $perPage) + 1;
                ?>
                @foreach ($results as $wiki)
                    <tr>
                    <td>{{ $i }}</td>
                          <td>{{ $wiki->changed_by ?? $wiki->user_name }}</td>
                          <td>{{ $wiki->wiki_name }}</td>
                          <td>{{ $wiki->wiki_type }}</td>
                          <td>{{ $wiki->ministry_name }}</td>
                          <td>{{ $wiki->department_name }}</td>
                          <td>{{ $wiki->segment_name }}</td>
                          <td>{{ $wiki->unit_name }}</td>
                          <td>{{ $wiki->sub_unit_name}}</td>
                          <td>{{ date('d-m-y', strtotime($wiki->created_at)) }}</td>
                          <td>{{ date('d-m-y', strtotime($wiki->updated_at)) }}</td>
                    </tr>
                    <?php $i ++; ?>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
            {{ $results->appends(request()->except('page'))->render("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
</div>

@include('partials.docx-poller')
