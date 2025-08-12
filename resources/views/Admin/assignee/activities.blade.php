@extends('layouts.admin_client_detail')
@section('title', 'Activities')

@section('content')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #343a40; line-height: 1.6; }
    .client-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 20px; }
    .client-header h1 { font-size: 1.8em; font-weight: 600; color: #212529; margin: 0; }
    .btn { padding: 8px 15px; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9em; font-weight: 500; transition: background-color 0.2s ease, box-shadow 0.2s ease; }
    .btn-primary { background-color: #0d6efd; color: white; }
    .btn-primary:hover { background-color: #0b5ed7; box-shadow: 0 2px 5px rgba(13, 110, 253, 0.3); }
    .tabs { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .tab-button { padding: 8px 15px; border: none; border-radius: 0px; background-color: #0d6efd; color: white; font-size: 0.9em; font-weight: 500; cursor: pointer; transition: background-color 0.2s ease; }
    .tab-button.active, .tab-button:hover { background-color: #0d6efd; color: #FFF !important;}
    .tab-button .badge { background-color: #ffffff; color: #0d6efd; border-radius: 10px; padding: 2px 6px; margin-left: 5px; font-size: 0.8em; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .table th, .table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; font-size: 0.9em; }
    .table th { background-color: #f8f9fa; font-weight: 600; color: #343a40; text-transform: uppercase; cursor: pointer; }
    .table tbody tr:hover { background-color: #f8f9fa; }
    .action-buttons .btn { margin-right: 5px; }
    .pagination { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 0.9em; text-decoration: none; color: #343a40; }
    .pagination a:hover { background-color: #f8f9fa; }
    .pagination .active span { background-color: #0d6efd; color: white; border-color: #0d6efd; }
    .table tbody td, .table thead th { color: #4a5568 !important; }
    .dataTables_wrapper .dataTables_length { margin-bottom: 0; }
    .dataTables_wrapper .dataTables_filter { display: none; } /* Hide default search */
    #DataTables_Table_0_info { margin-top: 20px; }
    .header-controls {
        display: flex;
        justify-content: flex-end; /* Align search bar to the right */
        align-items: center;
        margin-bottom: 20px;
    }
    .search-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .search-bar label { font-size: 0.9em; color: #343a40; }
    .search-bar input {
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 0.9em;
        width: 200px;
        flex-shrink: 0;
    }
    .bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        flex-wrap: nowrap;
    }
    .dataTables_length {
        flex-shrink: 0;
    }
    .dataTables_length select {
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 0.9em;
    }
    .dataTables_length label {
        font-size: 0.9em;
        color: #343a40;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .dataTables_info {
        flex-grow: 1;
        text-align: center;
        font-size: 0.9em;
        color: #343a40;
    }
    .error-message {
        color: red;
        font-size: 0.8em;
        margin-top: 5px;
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section" style="padding-top: 70px;">
        <div class="section-body">
            <div class="server-error">
                @include('../Elements/flash-message')
            </div>
            <div class="custom-error-msg"></div>

            <div class="client-header">
                <h1>Action</h1>
                <div class="client-status">
                    <a class="btn btn-primary" style="border-radius: 0px;" id="assigned_by_me"  href="{{URL::to('/admin/assigned_by_me')}}">Assigned by me</a>
                    <a class="btn btn-primary" style="border-radius: 0px;" id="archived-tab"  href="{{URL::to('/admin/activities_completed')}}">Completed</a>
                    <button class="btn btn-primary tab-button add_my_task" data-container="body" data-role="popover" data-placement="bottom" data-html="true" data-content="
                        <div id='popover-content11'>
                            <h4 class='text-center'>Add My Task</h4>
                            <div class='clearfix'></div>
                            <div class='box-header with-border'>
                                <div class='form-group row' style='margin-bottom:12px'>
                                    <label for='inputSub3' class='col-sm-3 control-label c6 f13' style='margin-top:8px'>Select Assignee</label>
                                    <div class='col-sm-9'>
                                        <div class='dropdown-multi-select' style='position: relative;display: inline-block;border: 1px solid #ccc;border-radius: 4px;padding: 8px;width: 336px;'>
                                            <button type='button' style='color: #34395e !important;border: none;width: 100%;text-align: left;' class='btn btn-default dropdown-toggle' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Assign User
                                            </button>
                                            <div class='dropdown-menu' style='min-width: 100%;max-height: 200px;overflow-y: auto;box-shadow: rgba(0, 0, 0, 0.2) 0px 8px 16px 0px;z-index: 1;padding: 8px;border-radius: 4px;border: 1px solid rgb(204, 204, 204);font-size: 14px;background-color: white;margin-left: -8px;position: absolute;transform: translate3d(8px, -107px, 0px);top: 0px;left: 0px;will-change: transform;' aria-labelledby='dropdownMenuButton'>
                                                @foreach(\App\Admin::where('role','!=',7)->where('status',1)->orderby('first_name','ASC')->get() as $admin)
                                                    <?php $branchname = \App\Branch::where('id',$admin->office_id)->first(); ?>
                                                    <label>
                                                        <input type='checkbox' class='checkbox-item' value='{{ $admin->id }}'>
                                                        {{ $admin->first_name }} {{ $admin->last_name }} ({{ @$branchname->office_name }})
                                                    </label><br>
                                                @endforeach
                                            </div>
                                        </div>
                                        <select class='d-none' id='rem_cat' name='rem_cat[]' multiple='multiple'>
                                            @foreach(\App\Admin::where('role','!=',7)->where('status',1)->orderby('first_name','ASC')->get() as $admin)
                                                <?php $branchname = \App\Branch::where('id',$admin->office_id)->first(); ?>
                                                <option value='{{ $admin->id }}'>{{ $admin->first_name }} {{ $admin->last_name }} ({{ @$branchname->office_name }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id='popover-content'>
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
                                            <input type='text' class='form-control f13 datepicker' placeholder='dd/mm/yyyy' id='popoverdatetime' value='<?php echo date('d/m/Y');?>' name='popoverdate'>
                                        </div>
                                    </div>
                                </div>
                                <input id='task_group' name='task_group' type='hidden' value='Personal Task'>
                                <form class='form-inline mr-auto'>
                                    <label for='inputSub3' class='col-sm-3 control-label c6 f13' style='margin-top:8px'>Select Client</label>
                                    <div class='search-element' style='margin-left: 5px;width:70%;'>
                                        <select id='assign_client_id' class='form-control js-data-example-ajaxccsearch__addmytask' type='search' placeholder='Search' aria-label='Search' data-width='200' style='width:200px'></select>
                                        <button class='btn' type='submit'><i class='fas fa-search'></i></button>
                                    </div>
                                </form>
                                <div class='box-footer' style='padding:10px 0'>
                                    <div class='row'>
                                        <input type='hidden' value='' id='popoverrealdate' name='popoverrealdate' />
                                    </div>
                                    <div class='row text-center'>
                                        <div class='col-md-12 text-center'>
                                            <button class='btn btn-info' id='add_my_task'>Add My Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>">
                        <i class="fas fa-plus"></i> Add New Task
                    </button>
                </div>
            </div>

            <!-- Tabs (Filters) -->
            <div class="tabs">
                <button class="tab-button active" data-filter="all">ALL <span class="badge" id="all-count">0</span></button>
                <button class="tab-button" data-filter="call">Call <span class="badge" id="call-count">0</span></button>
                <button class="tab-button" data-filter="checklist">Checklist <span class="badge" id="checklist-count">0</span></button>
                <button class="tab-button" data-filter="review">Review <span class="badge" id="review-count">0</span></button>
                <button class="tab-button" data-filter="query">Query <span class="badge" id="query-count">0</span></button>
                <button class="tab-button" data-filter="urgent">Urgent <span class="badge" id="urgent-count">0</span></button>
                <button class="tab-button" data-filter="personal_task">Personal Task <span class="badge" id="personal-task-count">0</span></button>
            </div>

            <!-- Header Controls (Only Search Bar) -->
            <div class="header-controls">
                <div class="search-bar">
                    <label for="searchInput">Search:</label>
                    <input type="text" id="searchInput" placeholder="Search tasks...">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                        <tr>
                            <th data-column="DT_RowIndex">Sno</th>
                            <th data-column="done">Done</th>
                            <th data-column="assigner_name">Assigner Name</th>
                            <th data-column="client_reference">Client Reference</th>
                            <th data-column="assign_date">Assign Date</th>
                            <th data-column="task_group">Type</th>
                            <th data-column="note_description">Note</th>
                            <th data-column="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
<style>
/* Ensure popovers display correctly */
.popover {
    z-index: 9999 !important;
    max-width: 500px !important;
}

.btn_readmore {
    color: #007bff !important;
    text-decoration: none !important;
    background: none !important;
    border: none !important;
    padding: 0 !important;
    font-size: inherit !important;
    cursor: pointer !important;
}

.btn_readmore:hover {
    color: #0056b3 !important;
    text-decoration: underline !important;
}

/* Ensure popover content is properly styled */
.popover-body {
    word-wrap: break-word;
    white-space: pre-wrap;
    max-height: 300px;
    overflow-y: auto;
}
</style>
<script type="text/javascript">
$(function () {
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('activities.list') }}",
            data: function(d) {
                d.filter = $('.tab-button.active').data('filter');
                d.search = $('#searchInput').val(); // Pass the search term to the server
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'done_task', name: 'done', orderable: false, searchable: false},
            {data: 'assigner_name', name: 'assigner_name', orderable: true, searchable: true},
            {data: 'client_reference', name: 'client_reference', orderable: true, searchable: true},
            {data: 'assign_date', name: 'assign_date', orderable: true, searchable: true},
            {data: 'task_group', name: 'task_group', orderable: true, searchable: true},
            {data: 'note_description', name: 'note_description', orderable: true, searchable: true},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "fnDrawCallback": function() {
            // Initialize popovers for dynamically added elements
            $('[data-toggle="popover"]').popover({
                html: true,
                sanitize: false,
                trigger: 'click',
                placement: 'top'
            });

            // Update badge counts
            updateBadgeCounts();
        },
        "bAutoWidth": false,
        "dom": 'rt<"bottom"lip><"clear">', // Move length menu (l) to bottom with info (i) and pagination (p)
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100], // Options for entries dropdown
        "order": [[4, 'desc']] // Default sorting by assign_date descending
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        table.ajax.reload(); // Trigger DataTables reload with the new search term
    });

    // Function to generate Update Task popover content
    function getUpdateTaskContent(assignedTo, noteId, taskId, taskGroup, followupDate, clientId) {
        // Convert followupDate to dd/mm/YYYY if it exists
        var formattedDate = followupDate ? moment(followupDate, 'YYYY-MM-DD').format('DD/MM/YYYY') : '<?php echo date('d/m/Y'); ?>';
        return `
            <div id="popover-content">
                <h4 class="text-center">Update Task</h4>
                <div class="clearfix"></div>
                <div class="box-header with-border">
                    <div class="form-group row" style="margin-bottom:12px">
                        <label for="inputSub3" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Select Assignee</label>
                        <div class="col-sm-9">
                            <select class="assigneeselect2 form-control selec_reg" id="rem_cat" name="rem_cat">
                                <option value="">Select</option>
                                @foreach(\App\Admin::where('role','!=',7)->where('status',1)->orderby('first_name','ASC')->get() as $admin)
                                    <?php $branchname = \App\Branch::where('id',$admin->office_id)->first(); ?>
                                    <option value="{{ $admin->id }}" ${assignedTo == {{ $admin->id }} ? 'selected' : ''}>
                                        {{ $admin->first_name }} {{ $admin->last_name }} ({{ @$branchname->office_name }})
                                    </option>
                                @endforeach
                            </select>
                            <div id="assignee-error" class="error-message"></div>
                        </div>
                    </div>
                </div>
                <div class="box-header with-border">
                    <div class="form-group row" style="margin-bottom:12px">
                        <label for="inputEmail3" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Note</label>
                        <div class="col-sm-9">
                            <textarea id="assignnote" class="form-control summernote-simple f13" placeholder="Enter a note....">${noteId || ''}</textarea>
                            <div id="note-error" class="error-message"></div>
                        </div>
                    </div>
                </div>
                <div class="box-header with-border">
                    <div class="form-group row" style="margin-bottom:12px">
                        <label for="inputEmail3" class="col-sm-3 control-label c6 f13" style="margin-top:8px">DateTime</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control f13 datepicker" placeholder="dd/mm/yyyy" id="popoverdatetime" value="${formattedDate}" name="popoverdate">
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom:12px">
                    <label for="inputSub3" class="col-sm-3 control-label c6 f13" style="margin-top:8px">Group</label>
                    <div class="col-sm-9">
                        <select class="assigneeselect2 form-control selec_reg" id="task_group" name="task_group">
                            <option value="">Select</option>
                            <option value="Call" ${taskGroup == 'Call' ? 'selected' : ''}>Call</option>
                            <option value="Checklist" ${taskGroup == 'Checklist' ? 'selected' : ''}>Checklist</option>
                            <option value="Review" ${taskGroup == 'Review' ? 'selected' : ''}>Review</option>
                            <option value="Query" ${taskGroup == 'Query' ? 'selected' : ''}>Query</option>
                            <option value="Urgent" ${taskGroup == 'Urgent' ? 'selected' : ''}>Urgent</option>
                        </select>
                        <div id="task-group-error" class="error-message"></div>
                    </div>
                </div>
                <input id="assign_note_id" type="hidden" value="${taskId}">
                <input id="assign_client_id" type="hidden" value="${clientId}">
                <div class="box-footer" style="padding:10px 0">
                    <div class="row">
                        <input type="hidden" value="" id="popoverrealdate" name="popoverrealdate" />
                    </div>
                    <div class="row text-center">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info" id="updateTask">Update Task</button>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    // Initialize datepicker for Add My Task popover
    $(document).on('shown.bs.popover', '.add_my_task', function() {
        $('#popoverdatetime').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            },
            autoApply: true
        });
        //$('.summernote-simple').summernote();
    });

    // Initialize datepicker for Update Task popover
    $(document).on('shown.bs.popover', '.update_task', function() {
        $('#popoverdatetime').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            },
            autoApply: true
        });
        //$('.assigneeselect2').select2();
        //$('.summernote-simple').summernote();
    });

    // Update badge counts
    function updateBadgeCounts() {
        $.ajax({
            url: "{{ route('activities.counts') }}",
            method: "GET",
            success: function(data) {
                $('#all-count').text(data.all || 0);
                $('#call-count').text(data.call || 0);
                $('#checklist-count').text(data.checklist || 0);
                $('#review-count').text(data.review || 0);
                $('#query-count').text(data.query || 0);
                $('#urgent-count').text(data.urgent || 0);
                $('#personal-task-count').text(data.personal_task || 0);
            }
        });
    }

    // Filter by tabs
    $('.tab-button').on('click', function() {
        $('.tab-button').removeClass('active');
        $(this).addClass('active');
        table.ajax.reload();
    });

    // Handle Update Task button click
    $('.yajra-datatable').on('click', '.update_task', function() {
        var $button = $(this);
        var assignedTo = $button.data('assignedto');
        var noteId = $button.data('noteid');
        var taskId = $button.data('taskid');
        var taskGroup = $button.data('taskgroupid');
        var followupDate = $button.data('followupdate');
        var clientId = $button.data('clientid');

        // Set popover content
        $button.popover('dispose'); // Dispose of any existing popover
        $button.popover({
            html: true,
            sanitize: false,
            content: getUpdateTaskContent(assignedTo, noteId, taskId, taskGroup, followupDate, clientId),
            trigger: 'manual',
            placement: 'left'
        }).popover('show');
    });

    // Close popover when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.popover').length && !$(e.target).closest('.update_task').length && !$(e.target).closest('.btn_readmore').length) {
            $('.update_task').popover('hide');
            $('.btn_readmore').popover('hide');
        }
    });

    // Handle Read More button clicks specifically
    $(document).on('click', '.btn_readmore', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $button = $(this);
        var fullContent = $button.data('full-content');
        
        // Hide any other open popovers
        $('.update_task').popover('hide');
        $('.btn_readmore').popover('hide');
        
        // Set popover content and show
        $button.popover('dispose');
        $button.popover({
            html: true,
            sanitize: false,
            content: fullContent,
            trigger: 'manual',
            placement: 'top'
        }).popover('show');
    });

    // Re-initialize popovers after DataTable redraw
    $(document).on('draw.dt', '.yajra-datatable', function() {
        // Destroy existing popovers
        $('.btn_readmore').popover('dispose');
    });

    // Handle Update Task submission
    $(document).on('click', '#updateTask', function() {
        var $popover = $(this).closest('.popover');
        var taskId = $popover.find('#assign_note_id').val();
        var clientId = $popover.find('#assign_client_id').val();
        var assignee = $popover.find('#rem_cat').val();
        var note = $popover.find('#assignnote').val();
        var followupDate = $popover.find('#popoverdatetime').val();
        var taskGroup = $popover.find('#task_group').val();

        // Clear previous error messages
        $popover.find('.error-message').text('');

        // Client-side validation
        var isValid = true;
        if (!assignee) {
            $popover.find('#assignee-error').text('Please select an assignee.');
            isValid = false;
        }
        if (!note) {
            $popover.find('#note-error').text('Please enter a note.');
            isValid = false;
        }
        if (!taskGroup) {
            $popover.find('#task-group-error').text('Please select a task group.');
            isValid = false;
        }

        if (!isValid) {
            return; // Stop submission if validation fails
        }

        // Convert dd/mm/YYYY to YYYY-MM-DD for server compatibility
        var formattedDate = moment(followupDate, 'DD/MM/YYYY').format('YYYY-MM-DD');

        $.ajax({
            type: 'post',
            url: "{{URL::to('/')}}/admin/update-task",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: taskId,
                client_id: clientId,
                assigned_to: assignee,
                description: note,
                followup_date: formattedDate,
                task_group: taskGroup
            },
            success: function(response) {
                $('.update_task').popover('hide');
                table.draw(false);
            },
            error: function(xhr) {
                console.error('Error updating task:', xhr.responseText);
                alert('An error occurred while updating the task. Please check the console for details.');
            }
        });
    });

    // Delete record
    $('.yajra-datatable').on('click', '.deleteNote', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = $(this).data('remote');
        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm) {
            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true}
            }).always(function(data) {
                table.draw(false);
            });
        }
    });

    // Complete task
    $('.yajra-datatable').on('click', '.complete_task', function() {
        var row_id = $(this).attr('data-id');
        var row_unique_group_id = $(this).attr('data-unique_group_id');
        if (row_id) {
            $.ajax({
                type: 'post',
                url: "{{URL::to('/')}}/admin/update-task-completed",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: row_id, unique_group_id: row_unique_group_id},
                success: function(response) {
                    table.draw(false);
                }
            });
        }
    });

    // Add My Task
    $(document).delegate('#add_my_task', 'click', function() {
        $(".popuploader").show();
        var flag = true;
        var error = "";
        $(".custom-error").remove();

        var selectedRemCat = [];
        $(".checkbox-item:checked").each(function() {
            selectedRemCat.push($(this).val());
        });

        if (selectedRemCat.length === 0) {
            $('.popuploader').hide();
            error = "Assignee field is required.";
            $('#dropdownMenuButton').after("<span class='custom-error' role='alert'>" + error + "</span>");
            flag = false;
        }

        if ($('#assignnote').val() == '') {
            $('.popuploader').hide();
            error = "Note field is required.";
            $('#assignnote').after("<span class='custom-error' role='alert'>" + error + "</span>");
            flag = false;
        }

        if (flag) {
            // Convert dd/mm/YYYY to YYYY-MM-DD for server compatibility
            var followupDate = $('#popoverdatetime').val();
            var formattedDate = moment(followupDate, 'DD/MM/YYYY').format('YYYY-MM-DD');

            $.ajax({
                type: 'post',
                url: "{{URL::to('/')}}/admin/clients/personalfollowup/store",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    note_type: 'follow_up',
                    description: $('#assignnote').val(),
                    client_id: $('#assign_client_id').val(),
                    followup_datetime: formattedDate,
                    rem_cat: selectedRemCat,
                    task_group: $('#task_group').val()
                },
                success: function(response) {
                    $('.popuploader').hide();
                    var obj = $.parseJSON(response);
                    if (obj.success) {
                        $("[data-role=popover]").each(function() {
                            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false
                        });
                        table.draw(false);
                        getallactivities();
                        getallnotes();
                    } else {
                        alert(obj.message);
                        table.draw(false);
                    }
                }
            });
        } else {
            $("#loader").hide();
        }
    });
});
</script>
@endsection
