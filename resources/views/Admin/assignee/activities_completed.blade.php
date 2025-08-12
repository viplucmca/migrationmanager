@extends('layouts.admin_client_detail')
@section('title', 'Completed Activities')

@section('content')
<style>
    .main-content { padding: 20px; }
    .section-body { margin-top: 20px; }
    .filter-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .filter-buttons a, .filter-buttons button {
        /*background-color: #e9ecef;
        color: #495057;*/
        background-color: #0d6efd;
        color: #FFF;
        padding: 8px 15px;
        /*border-radius: 20px;*/
        font-size: 0.9em;
        font-weight: 500;
        text-decoration: none;
        border: none;
        transition: background-color 0.2s ease;
    }
    .filter-buttons a.active, .filter-buttons button.active {
        background-color: #0d6efd;
        color: white;
    }
    .filter-buttons a:hover, .filter-buttons button:hover {
        background-color: #d3d7db;
    }
    .filter-buttons .countAction {
        background-color: #ffffff;
        color: #0d6efd;

        padding: 2px 8px;
        border-radius: 50%;
        font-size: 0.8em;
        margin-left: 5px;
    }
    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 0.9em; }
    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #343a40;
        text-transform: uppercase;
        font-size: 0.85em;
    }
    .table td { color: #495057; }
    .table tr:hover { background-color: #f8f9fa; }
    .action-buttons { display: flex; gap: 5px; }
    .action-buttons .btn {
        padding: 5px 10px;
        font-size: 0.9em;
        border-radius: 4px;
    }
    .btn-primary { background-color: #0d6efd; color: white; }
    .btn-danger { background-color: #dc3545; color: white; }
    .btn-primary:hover { background-color: #0b5ed7; }
    .btn-danger:hover { background-color: #c82333; }
    .sort_col a { color: #0d6efd !important; text-decoration: none; }
    .sort_col a:hover { text-decoration: underline; }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="server-error">
                @include('../Elements/flash-message')
            </div>
            <div class="custom-error-msg"></div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card" style="margin-top: 50px;">
                        <div class="card-header">
                            <h4 style="color: #000;">Completed Activities</h4>
                            <ul class="nav nav-pills" id="client_tabs" role="tablist" style="margin-left: 942px;">
                                <li class="nav-item is_checked_clientn11">
                                    <a class="nav-link active" id="archived-tab" href="{{URL::to('/admin/activities')}}">Incomplete</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="quotationContent">
                                <form action="{{ route('assignee.activities_completed') }}" method="get">
                                    <div class="row">
                                        <div class="col-md-12 filter-buttons">
                                            <?php
                                            if(\Auth::user()->role == 1){
                                                $assigneesCount_All_type = \App\Note::where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_call_type = \App\Note::where('task_group','like','Call')->where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Checklist_type = \App\Note::where('task_group','like','Checklist')->where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Review_type = \App\Note::where('task_group','like','Review')->where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Query_type = \App\Note::where('task_group','like','Query')->where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Urgent_type = \App\Note::where('task_group','like','Urgent')->where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Personal_Task_type = \App\Note::where('task_group','like','Personal Task')->where('type','client')->whereNotNull('client_id')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                            } else {
                                                $assigneesCount_All_type = \App\Note::where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_call_type = \App\Note::where('task_group','like','Call')->where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Checklist_type = \App\Note::where('task_group','like','Checklist')->where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Review_type = \App\Note::where('task_group','like','Review')->where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Query_type = \App\Note::where('task_group','like','Query')->where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Urgent_type = \App\Note::where('task_group','like','Urgent')->where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                                $assigneesCount_Personal_Task_type = \App\Note::where('task_group','like','Personal Task')->where('assigned_to',Auth::user()->id)->where('type','client')->where('folloup',1)->where('status',1)->orderBy('created_at', 'desc')->count();
                                            }
                                            ?>
                                            <a href="{{URL::to('/admin/activities_completed?group_type=All')}}" id="All" class="group_type {{ $task_group == 'All' ? 'active' : '' }}">All <span class="countAction">{{ $assigneesCount_All_type }}</span></a>
                                            <button type="button">
                                                <a href="{{URL::to('/admin/activities_completed?group_type=Call')}}" id="Call" class="group_type {{ $task_group == 'Call' ? 'active' : '' }}"><i class="fa fa-phone" aria-hidden="true"></i> Call <span class="countAction">{{ $assigneesCount_call_type }}</span></a>
                                            </button>
                                            <button type="button">
                                                <a href="{{URL::to('/admin/activities_completed?group_type=Checklist')}}" id="Checklist" class="group_type {{ $task_group == 'Checklist' ? 'active' : '' }}"><i class="fa fa-bars" aria-hidden="true"></i> Checklist <span class="countAction">{{ $assigneesCount_Checklist_type }}</span></a>
                                            </button>
                                            <button type="button">
                                                <a href="{{URL::to('/admin/activities_completed?group_type=Review')}}" id="Review" class="group_type {{ $task_group == 'Review' ? 'active' : '' }}"><i class="fa fa-check" aria-hidden="true"></i> Review <span class="countAction">{{ $assigneesCount_Review_type }}</span></a>
                                            </button>
                                            <button type="button">
                                                <a href="{{URL::to('/admin/activities_completed?group_type=Query')}}" id="Query" class="group_type {{ $task_group == 'Query' ? 'active' : '' }}"><i class="fa fa-question" aria-hidden="true"></i> Query <span class="countAction">{{ $assigneesCount_Query_type }}</span></a>
                                            </button>
                                            <button type="button">
                                                <a href="{{URL::to('/admin/activities_completed?group_type=Urgent')}}" id="Urgent" class="group_type {{ $task_group == 'Urgent' ? 'active' : '' }}"><i class="fa fa-flag" aria-hidden="true"></i> Urgent <span class="countAction">{{ $assigneesCount_Urgent_type }}</span></a>
                                            </button>
                                            <button type="button">
                                                <a href="{{URL::to('/admin/activities_completed?group_type=Personal Task')}}" id="Personal Task" class="group_type {{ $task_group == 'Personal Task' ? 'active' : '' }}"><i class="fa fa-tasks" aria-hidden="true"></i> Personal Task <span class="countAction">{{ $assigneesCount_Personal_Task_type }}</span></a>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="tab-pane fade show active" id="active_quotation" role="tabpanel" aria-labelledby="active_quotation-tab">
                                    <div class="table-responsive common_table">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="text-align: center;">Sno</th>
                                                <th style="text-align: center;">Done</th>
                                                <th>Assigner Name</th>
                                                <th>Client Reference</th>
                                                <th class="sort_col">@sortablelink('followup_date','Assign Date')</th>
                                                <th class="sort_col">@sortablelink('task_group','Type')</th>
                                                <th>Note</th>
                                                <th>Action</th>
                                            </tr>
                                            @if(count($assignees_completed) > 0)
                                                @foreach($assignees_completed as $list)
                                                    <?php
                                                        $admin = \App\Admin::where('id', $list->user_id)->first();
                                                        $full_name = $admin ? ($admin->first_name ?? 'N/A') . ' ' . ($admin->last_name ?? 'N/A') : 'N/A';
                                                        $user_name = $list->noteClient ? $list->noteClient->first_name . ' ' . $list->noteClient->last_name : 'N/P';
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center;">{{ ++$i }}</td>
                                                        <td style="text-align: center;">
                                                            <input type="radio" class="not_complete_task" data-toggle="tooltip" title="Mark Incomplete!" data-id="{{ $list->id }}" data-unique_group_id="{{ $list->unique_group_id }}">
                                                        </td>
                                                        <td>{{ $full_name }}</td>
                                                        <td>
                                                            {{ $user_name }}<br>
                                                            @if($list->noteClient)
                                                                <a href="{{URL::to('/admin/clients/detail/'.base64_encode(convert_uuencode(@$list->client_id)))}}" target="_blank">{{ $list->noteClient->client_id }}</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ date('d/m/Y', strtotime($list->followup_date)) ?? 'N/P' }}</td>
                                                        <td>{{ $list->task_group ?? 'N/P' }}</td>
                                                        <td>
                                                            @if(isset($list->description) && $list->description != "")
                                                                @if(strlen($list->description) > 190)
                                                                    <?php
                                                                        $full_description = $list->description;
                                                                        $new_string = substr($list->description, 0, 190) . ' <button type="button" class="btn btn-link" data-toggle="popover" title="" data-content="' . $full_description . '">Read more</button>';
                                                                        echo $new_string;
                                                                    ?>
                                                                @else
                                                                    {{ $list->description }}
                                                                @endif
                                                            @else
                                                                N/P
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                @if($list->task_group != 'Personal Task')
                                                                    <button type="button" data-noteid="{{ $list->description }}" data-taskid="{{ $list->id }}" data-taskgroupid="{{ $list->task_group }}" data-followupdate="{{ $list->followup_date }}" data-toggle="tooltip" title="Update Task" class="btn btn-primary update_task" data-container="body" data-role="popover" data-placement="bottom" data-html="true" data-content="<div id='popover-content'>
                                                                        <h4 class='text-center'>Update Task</h4>
                                                                        <div class='clearfix'></div>
                                                                        <div class='box-header with-border'>
                                                                            <div class='form-group row' style='margin-bottom:12px'>
                                                                                <label for='inputSub3' class='col-sm-3 control-label c6 f13' style='margin-top:8px'>Select Assignee</label>
                                                                                <div class='col-sm-9'>
                                                                                    <select class='assigneeselect2 form-control selec_reg' id='rem_cat' name='rem_cat'>
                                                                                        <option value=''>Select</option>
                                                                                        @foreach(\App\Admin::where('role','!=',7)->where('status',1)->orderby('first_name','ASC')->get() as $admin)
                                                                                            <?php $branchname = \App\Branch::where('id', $admin->office_id)->first(); ?>
                                                                                            <option value='{{ $admin->id }}' {{ $admin->id == $list->assigned_to ? 'selected' : '' }}>{{ $admin->first_name . ' ' . $admin->last_name . ' (' . @$branchname->office_name . ')' }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class='box-header with-border'>
                                                                            <div class='form-group row' style='margin-bottom:12px'>
                                                                                <label for='inputEmail3' class='col-sm-3 control-label c6 f13' style='margin-top:8px'>Note</label>
                                                                                <div class='col-sm-9'>
                                                                                    <textarea id='assignnote' class='form-control summernote-simple f13' placeholder='Enter a note....' type='text'></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class='box-header with-border'>
                                                                            <div class='form-group row' style='margin-bottom:12px'>
                                                                                <label for='inputEmail3' class='col-sm-3 control-label c6 f13' style='margin-top:8px'>DateTime</label>
                                                                                <div class='col-sm-9'>
                                                                                    <input type='date' class='form-control f13' placeholder='yyyy-mm-dd' id='popoverdatetime' value='{{ date('Y-m-d') }}' name='popoverdate'>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class='form-group row' style='margin-bottom:12px'>
                                                                            <label for='inputSub3' class='col-sm-3 control-label c6 f13' style='margin-top:8px'>Group</label>
                                                                            <div class='col-sm-9'>
                                                                                <select class='assigneeselect2 form-control selec_reg' id='task_group' name='task_group'>
                                                                                    <option value=''>Select</option>
                                                                                    <option value='Call'>Call</option>
                                                                                    <option value='Checklist'>Checklist</option>
                                                                                    <option value='Review'>Review</option>
                                                                                    <option value='Query'>Query</option>
                                                                                    <option value='Urgent'>Urgent</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <input id='assign_note_id' type='hidden' value=''>
                                                                        <input id='assign_client_id' type='hidden' value='{{ base64_encode(convert_uuencode(@$list->client_id)) }}'>
                                                                        <div class='box-footer' style='padding:10px 0'>
                                                                            <div class='row text-center'>
                                                                                <div class='col-md-12 text-center'>
                                                                                    <button class='btn btn-info' id='updateTask'>Update Task</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>">
                                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                                    </button>
                                                                @endif

                                                                <form action="{{ route('assignee.destroy_complete_activity', $list->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete?');">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8"><b>There are no completed activities.</b></td>
                                                </tr>
                                            @endif
                                        </table>
                                        {!! $assignees_completed->appends($_GET)->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Assign Modal -->
<div class="modal fade custom_modal" id="openassigneview" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content taskview"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::to('/')}}/js/popover.js"></script>
<script>
jQuery(document).ready(function($){
    $('[data-toggle="tooltip"]').tooltip();

    $(document).delegate('.openassignee', 'click', function(){
        $('.assignee').show();
    });

    $(document).delegate('.closeassignee', 'click', function(){
        $('.assignee').hide();
    });

    // Reassign task
    $(document).delegate('.reassign_task', 'click', function(){
        var note_id = $(this).attr('data-noteid');
        $('#assignnote').val(note_id);
        var task_id = $(this).attr('data-taskid');
        $('#assign_note_id').val(task_id);
    });

    // Update task
    $(document).delegate('.update_task', 'click', function(){
        var note_id = $(this).attr('data-noteid');
        $('#assignnote').val(note_id);
        var task_id = $(this).attr('data-taskid');
        $('#assign_note_id').val(task_id);
        var taskgroup_id = $(this).attr('data-taskgroupid');
        $('#task_group').val(taskgroup_id);
        var followupdate_id = $(this).attr('data-followupdate');
        $('#popoverdatetime').val(followupdate_id);
    });

    // Mark task as incomplete
    $(document).delegate('.not_complete_task', 'click', function(){
        var row_id = $(this).attr('data-id');
        var row_unique_group_id = $(this).attr('data-unique_group_id');
        if(row_id != ""){
            $.ajax({
                type: 'post',
                url: "{{URL::to('/')}}/admin/update-task-not-completed",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { id: row_id, unique_group_id: row_unique_group_id },
                success: function(response){
                    var obj = $.parseJSON(response);
                    location.reload();
                }
            });
        }
    });

    // Assign user
    $(document).delegate('#assignUser', 'click', function(){
        $(".popuploader").show();
        var flag = true;
        var error = "";
        $(".custom-error").remove();

        if($('#rem_cat').val() == ''){
            $('.popuploader').hide();
            error = "Assignee field is required.";
            $('#rem_cat').after("<span class='custom-error' role='alert'>" + error + "</span>");
            flag = false;
        }
        if($('#assignnote').val() == ''){
            $('.popuploader').hide();
            error = "Note field is required.";
            $('#assignnote').after("<span class='custom-error' role='alert'>" + error + "</span>");
            flag = false;
        }
        if($('#task_group').val() == ''){
            $('.popuploader').hide();
            error = "Group field is required.";
            $('#task_group').after("<span class='custom-error' role='alert'>" + error + "</span>");
            flag = false;
        }
        if(flag){
            $.ajax({
                type: 'post',
                url: "{{URL::to('/')}}/admin/clients/reassignfollowup/store",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    note_type: 'follow_up',
                    description: $('#assignnote').val(),
                    client_id: $('#assign_client_id').val(),
                    followup_datetime: $('#popoverdatetime').val(),
                    assignee_name: $('#rem_cat :selected').text(),
                    rem_cat: $('#rem_cat option:selected').val(),
                    task_group: $('#task_group option:selected').val()
                },
                success: function(response){
                    $('.popuploader').hide();
                    var obj = $.parseJSON(response);
                    if(obj.success){
                        $("[data-role=popover]").each(function(){
                            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false
                        });
                        location.reload();
                        getallactivities();
                        getallnotes();
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

    $(document).delegate('.openassigneview', 'click', function(){
        $('#openassigneview').modal('show');
        var v = $(this).attr('id');
        $.ajax({
            url: site_url + '/admin/get-assigne-detail',
            type: 'GET',
            data: { id: v },
            success: function(responses){
                $('.popuploader').hide();
                $('.taskview').html(responses);
            }
        });
    });
});
</script>
@endsection
