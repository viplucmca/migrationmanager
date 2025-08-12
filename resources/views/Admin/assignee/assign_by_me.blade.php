@extends('layouts.admin_client_detail')
@section('title', 'Assigned by Me')

@section('styles')
<style>

    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 0.9em; }
    .table th, .table td { padding: 12px; border-bottom: 1px solid #e9ecef; text-align: left; }
    .table th { background-color: #f8f9fa; font-weight: 600; color: #343a40; }
    .table tr:hover { background-color: #f1f3f5; }
    .sort_col a { color: #0d6efd !important; text-decoration: none; }
    .sort_col a:hover { text-decoration: underline; }
    .countAction { background: #1f1655; padding: 2px 8px; border-radius: 50%; color: #fff; font-size: 0.8em; margin-left: 5px; }
    .complete_task { cursor: pointer; }
    .btn-sm { padding: 5px 10px; font-size: 0.85em; }
    .modal-content { border-radius: 8px; }
    .modal-header { background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; }
    .modal-body { padding: 20px; }
    .select2-container { z-index: 100000; width: 100% !important; }
    .table tbody td, .table thead th { color: #4a5568 !important; }

    /* Fix for search box in header */
    .navbar-bg { background-color: #fff; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
    .main-navbar { padding: 10px 20px; }
    .main-navbar .js-data-example-ajaxccsearch { width: 300px; }
    .select2-container--default .select2-selection--single {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        height: 38px;
        padding: 5px;
        background-color: #fff;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #343a40;
        line-height: 28px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .select2-dropdown {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .select2-results__option {
        padding: 8px 12px;
        color: #343a40;
    }
    .select2-results__option--highlighted {
        background-color: #f1f3f5;
        color: #0d6efd;
    }

    .nav-pills .nav-item .nav-link {
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .table th, .table td { font-size: 0.85em; padding: 8px; }
        .btn-sm { padding: 4px 8px; }
        .main-navbar .js-data-example-ajaxccsearch { width: 200px; }
    }
</style>
@endsection

@section('content')
<div class="crm-container">
    <div class="main-content">
        <div class="client-header">
            <h1>Assigned by Me</h1>
            <div class="client-status">
                <ul class="nav nav-pills" id="client_tabs" role="tablist">
                    <li class="nav-item">
                        <a class="status-badge nav-link active" href="{{ URL::to('/admin/activities') }}">Incomplete</a>
                    </li>
                    <li class="nav-item">
                        <a class="status-badge nav-link" href="{{ URL::to('/admin/activities_completed') }}">Completed</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('assignee.assigned_by_me') }}" method="get" class="mb-4">
                    <div class="row">
                        <div class="col-md-12 group_type_section">
                            <!-- Add filters if needed -->
                        </div>
                    </div>
                </form>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="active_quotation" role="tabpanel">
                        <div class="table-responsive">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align: center;">Sno</th>
                                        <th width="5%" style="text-align: center;">Done</th>
                                        <th width="15%">Assignee Name</th>
                                        <th width="15%">Client Reference</th>
                                        <th width="15%" class="sort_col">@sortablelink('followup_date', 'Assign Date')</th>
                                        <th width="10%" class="sort_col">@sortablelink('task_group', 'Type')</th>
                                        <th>Note</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($assignees_notCompleted) > 0)
                                        @foreach ($assignees_notCompleted as $list)
                                            @php
                                                $admin = \App\Admin::where('id', $list->assigned_to)->first();
                                                $full_name = $admin ? ($admin->first_name ?? 'N/A') . ' ' . ($admin->last_name ?? 'N/A') : 'N/P';
                                                $user_name = $list->noteClient ? $list->noteClient->first_name . ' ' . $list->noteClient->last_name : 'N/P';
                                            @endphp
                                            <tr>
                                                <td style="text-align: center;">{{ ++$i }}</td>
                                                <td style="text-align: center;">
                                                    <input type="radio" class="complete_task" data-toggle="tooltip" title="Mark Complete!" data-id="{{ $list->id }}" data-unique_group_id="{{ $list->unique_group_id }}">
                                                </td>
                                                <td>{{ $full_name }}</td>
                                                <td>
                                                    {{ $user_name }}
                                                    <br>
                                                    @if ($list->noteClient)
                                                        <a href="{{ URL::to('/admin/clients/detail/' . base64_encode(convert_uuencode($list->client_id))) }}" target="_blank">{{ $list->noteClient->client_id }}</a>
                                                    @endif
                                                </td>
                                                <td>{{ $list->followup_date ? date('d/m/Y', strtotime($list->followup_date)) : 'N/P' }}</td>
                                                <td>{{ $list->task_group ?? 'N/P' }}</td>
                                                <td>
                                                    @if (isset($list->description) && $list->description != "")
                                                        @if (strlen($list->description) > 190)
                                                            {!! substr($list->description, 0, 190) !!}
                                                            <button type="button" class="btn btn-link" data-toggle="popover" title="" data-content="{{ $list->description }}">Read more</button>
                                                        @else
                                                            {!! $list->description !!}
                                                        @endif
                                                    @else
                                                        N/P
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($list->task_group != 'Personal Task')
                                                        <button type="button" data-noteid="{{ $list->description }}" data-taskid="{{ $list->id }}" data-taskgroupid="{{ $list->task_group }}" data-followupdate="{{ $list->followup_date }}" class="btn btn-primary btn-sm update_task" data-toggle="tooltip" title="Update Task" data-container="body" data-role="popover" data-placement="bottom" data-html="true" data-content='
                                                            <div id="popover-content">
                                                                <h4 class="text-center">Update Task</h4>
                                                                <div class="form-group row" style="margin-bottom:12px">
                                                                    <label for="rem_cat" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Select Assignee</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="assigneeselect2 form-control selec_reg" id="rem_cat" name="rem_cat">
                                                                            <option value="">Select</option>
                                                                            @foreach (\App\Admin::where('role', '!=', 7)->where('status', 1)->orderBy('first_name', 'ASC')->get() as $admin)
                                                                                @php
                                                                                    $branchname = \App\Branch::where('id', $admin->office_id)->first();
                                                                                @endphp
                                                                                <option value="{{ $admin->id }}" {{ $admin->id == $list->assigned_to ? 'selected' : '' }}>{{ $admin->first_name . ' ' . $admin->last_name . ' (' . ($branchname->office_name ?? 'N/A') . ')' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom:12px">
                                                                    <label for="assignnote" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Note</label>
                                                                    <div class="col-sm-9">
                                                                        <textarea id="assignnote" class="form-control summernote-simple f13" placeholder="Enter a note..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom:12px">
                                                                    <label for="popoverdatetime" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Date</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="date" class="form-control f13" placeholder="yyyy-mm-dd" id="popoverdatetime" value="{{ date('Y-m-d') }}" name="popoverdate">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row" style="margin-bottom:12px">
                                                                    <label for="task_group" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Group</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="assigneeselect2 form-control selec_reg" id="task_group" name="task_group">
                                                                            <option value="">Select</option>
                                                                            <option value="Call">Call</option>
                                                                            <option value="Checklist">Checklist</option>
                                                                            <option value="Review">Review</option>
                                                                            <option value="Query">Query</option>
                                                                            <option value="Urgent">Urgent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <input id="assign_note_id" type="hidden" value="">
                                                                <input id="assign_client_id" type="hidden" value="{{ base64_encode(convert_uuencode($list->client_id)) }}">
                                                                <div class="text-center">
                                                                    <button class="btn btn-info" id="updateTask">Update Task</button>
                                                                </div>
                                                            </div>'>
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </button>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center"><b>No activities assigned by me.</b></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {!! $assignees_notCompleted->appends($_GET)->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign Modal -->
<div class="modal fade custom_modal" id="openassigneview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content taskview">
            <!-- Modal content will be loaded dynamically -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::to('/') }}/js/popover.js"></script>
<script>
    jQuery(document).ready(function($) {
        // Initialize Select2 for search box in header
        $('.js-data-example-ajaxccsearch').select2({
            closeOnSelect: true,
            ajax: {
                url: '{{URL::to('/admin/clients/get-allclients')}}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            templateResult: function(repo) {
                if (repo.loading) {
                    return repo.text;
                }
                var $container = $(
                    "<div dataid="+repo.cid+" class='selectclient select2-result-repository ag-flex ag-space-between ag-align-center'>" +
                    "<div class='ag-flex ag-align-start'>" +
                        "<div class='ag-flex ag-flex-column col-hr-1'><div class='ag-flex'><span class='select2-result-repository__title text-semi-bold'></span>&nbsp;</div>" +
                        "<div class='ag-flex ag-align-center'><small class='select2-result-repository__description'></small></div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='ag-flex ag-flex-column ag-align-end'>" +
                        "<span class='select2resultrepositorystatistics'>" +
                        "</span>" +
                    "</div>" +
                    "</div>"
                );
                $container.find(".select2-result-repository__title").text(repo.name);
                $container.find(".select2-result-repository__description").text(repo.email);
                if (repo.status == 'Archived') {
                    $container.find(".select2resultrepositorystatistics").append('<span class="ui label select2-result-repository__statistics">'+repo.status+'</span>');
                } else {
                    $container.find(".select2resultrepositorystatistics").append('<span class="ui label yellow select2-result-repository__statistics">'+repo.status+'</span>');
                }
                return $container;
            },
            templateSelection: function(repo) {
                return repo.name || repo.text;
            }
        });

        // Redirect on search selection
        $('.js-data-example-ajaxccsearch').on('change', function() {
            var v = $(this).val();
            var s = v.split('/');
            if (s[1] == 'Client') {
                window.location = '{{URL::to('/admin/clients/detail/')}}/'+s[0];
            } else {
                window.location = '{{URL::to('/admin/leads/history/')}}/'+s[0];
            }
            return false;
        });

        // Initialize Select2 for assignee dropdowns
        $('.assigneeselect2').select2({
            dropdownParent: $('#openassigneview'),
        });

        // Open assignee modal
        $(document).on('click', '.openassignee', function() {
            $('.assignee').show();
        });

        $(document).on('click', '.closeassignee', function() {
            $('.assignee').hide();
        });

        // Reassign task
        $(document).on('click', '.reassign_task', function() {
            var note_id = $(this).attr('data-noteid');
            $('#assignnote').val(note_id);
            var task_id = $(this).attr('data-taskid');
            $('#assign_note_id').val(task_id);
        });

        // Update task
        $(document).on('click', '.update_task', function() {
            var note_id = $(this).attr('data-noteid');
            $('#assignnote').val(note_id);
            var task_id = $(this).attr('data-taskid');
            $('#assign_note_id').val(task_id);
            var taskgroup_id = $(this).attr('data-taskgroupid');
            $('#task_group').val(taskgroup_id);
            var followupdate_id = $(this).attr('data-followupdate');
            $('#popoverdatetime').val(followupdate_id);
        });

        // Mark task as not complete
        $(document).on('click', '.not_complete_task', function() {
            var row_id = $(this).attr('data-id');
            var row_unique_group_id = $(this).attr('data-unique_group_id');
            if (row_id != "") {
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('/') }}/admin/update-task-not-completed",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { id: row_id, unique_group_id: row_unique_group_id },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });

        // Mark task as complete
        $(document).on('click', '.complete_task', function() {
            var row_id = $(this).attr('data-id');
            var row_unique_group_id = $(this).attr('data-unique_group_id');
            if (row_id != "") {
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('/') }}/admin/update-task-completed",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { id: row_id, unique_group_id: row_unique_group_id },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });

        // Update task
        $(document).on('click', '#updateTask', function() {
            $(".popuploader").show();
            var flag = true;
            var error = "";
            $(".custom-error").remove();

            if ($('#rem_cat').val() == '') {
                $('.popuploader').hide();
                error = "Assignee field is required.";
                $('#rem_cat').after("<span class='custom-error' role='alert'>" + error + "</span>");
                flag = false;
            }
            if ($('#assignnote').val() == '') {
                $('.popuploader').hide();
                error = "Note field is required.";
                $('#assignnote').after("<span class='custom-error' role='alert'>" + error + "</span>");
                flag = false;
            }
            if ($('#task_group').val() == '') {
                $('.popuploader').hide();
                error = "Group field is required.";
                $('#task_group').after("<span class='custom-error' role='alert'>" + error + "</span>");
                flag = false;
            }
            if (flag) {
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('/') }}/admin/clients/updatefollowup/store",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        note_id: $('#assign_note_id').val(),
                        note_type: 'follow_up',
                        description: $('#assignnote').val(),
                        client_id: $('#assign_client_id').val(),
                        followup_datetime: $('#popoverdatetime').val(),
                        assignee_name: $('#rem_cat :selected').text(),
                        rem_cat: $('#rem_cat option:selected').val(),
                        task_group: $('#task_group option:selected').val()
                    },
                    success: function(response) {
                        $('.popuploader').hide();
                        var obj = $.parseJSON(response);
                        if (obj.success) {
                            $("[data-role=popover]").each(function() {
                                (($(this).popover('hide').data('bs.popover') || {}).inState || {}).click = false;
                            });
                            location.reload();
                        } else {
                            alert(obj.message);
                            location.reload();
                        }
                    }
                });
            } else {
                $("#loader").hide();
            }
        });

        // Open assignee view modal
        $(document).on('click', '.openassigneview', function() {
            $('#openassigneview').modal('show');
            var v = $(this).attr('id');
            $.ajax({
                url: site_url + '/admin/get-assigne-detail',
                type: 'GET',
                data: { id: v },
                success: function(responses) {
                    $('.popuploader').hide();
                    $('.taskview').html(responses);
                }
            });
        });
    });
</script>
@endsection
