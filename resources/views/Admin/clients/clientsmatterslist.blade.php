@extends('layouts.admin_client_detail')
@section('title', 'Clients Matters')

@section('styles')
<style>
    /* Modern Card Design */
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        margin: 20px 0;
        border: none;
        width: 100%;
    }

    .card-header {
        background: #fff;
        padding: 20px 30px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 12px 0 0;
    }

    .card-header h4 {
        font-size: 1.25rem;
        color: #2d3748;
        font-weight: 600;
        margin: 0;
    }

    .card-body {
        padding: 30px;
        background: #fff;
        border-radius: 0 0 12px 12px;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 0 1px #f0f0f0;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.875rem;
        margin: 0;
    }

    .table thead th {
        background: #f8fafc;
        color: #4a5568 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 16px;
        border-bottom: 2px solid #edf2f7;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 16px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568 !important;
        vertical-align: middle;
        transition: all 0.2s;
    }

    .table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Checkbox Styling */
    .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #4299e1;
        border-color: #4299e1;
    }

    .custom-control-label::before {
        border-radius: 4px;
        border: 2px solid #cbd5e0;
    }

    /* Button Styling */
    .btn-primary.Validate_Receipt {
        background: #394eea;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        color: white;
    }

    .btn-primary.Validate_Receipt:hover {
        background: #2d3eb8;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(57, 78, 234, 0.1);
    }

    .btn-primary.Validate_Receipt i {
        font-size: 0.875rem;
    }

    /* Filter Button Styling */
    .btn-theme.filter_btn {
        background: #394eea;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        color: white;
    }

    .btn-theme.filter_btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(57, 78, 234, 0.1);
        color: white;
    }

    .btn-theme.filter_btn i {
        font-size: 0.875rem;
    }

    /* Status Indicators */
    .text-success, .text-danger {
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .text-success {
        background-color: #c6f6d5;
        color: #2f855a !important;
    }

    .text-danger {
        background-color: #fed7d7;
        color: #c53030 !important;
    }

    /* Pagination Styling */
    .card-footer {
        background: transparent;
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        justify-content: center;
    }

    .pagination li {
        margin: 0 3px;
    }

    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 6px;
        font-size: 14px;
        color: #666;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination li.active span {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .pagination li.disabled span {
        color: #ccc;
        background-color: #fff;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    .pagination li a:hover:not(.disabled) {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0056b3;
        text-decoration: none;
    }

    /* Next/Previous buttons */
    .pagination li:first-child,
    .pagination li:last-child {
        margin: 0 5px;
    }

    .pagination li:first-child a,
    .pagination li:last-child a {
        padding: 0;
        font-size: 14px;
        color: #666;
    }

    .pagination li:first-child a:hover,
    .pagination li:last-child a:hover {
        color: #0056b3;
    }

    /* Text showing current range */
    .showing-text {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }

    @media (max-width: 576px) {
        .pagination li a,
        .pagination li span {
            min-width: 30px;
            height: 30px;
            font-size: 13px;
        }

        .pagination li:first-child,
        .pagination li:last-child {
            margin: 0 3px;
        }
    }

    /* Column width adjustments */
    .table th:nth-child(1) { width: 15%; } /* Matter */
    .table th:nth-child(2) { width: 10%; } /* Client ID */
    .table th:nth-child(3) { width: 15%; } /* Client Name */
    .table th:nth-child(4) { width: 15%; } /* Migration Agent */
    .table th:nth-child(5) { width: 15%; } /* Person Responsible */
    .table th:nth-child(6) { width: 15%; } /* Person Assisting */
    .table th:nth-child(7) { width: 8%; }  /* Created At */
    .table th:nth-child(8) { width: 7%; }  /* Action */

    /* Table cell styling for better text wrapping */
    .table td {
        white-space: normal;
        word-wrap: break-word;
        max-width: 0;
        padding: 12px 8px;
        vertical-align: middle;
    }

    /* Ensure table headers don't wrap */
    .table th {
        white-space: nowrap;
        padding: 12px 8px;
    }

    /* Add minimum width to prevent columns from becoming too narrow */
    .table th:nth-child(1) { min-width: 150px; }
    .table th:nth-child(2) { min-width: 100px; }
    .table th:nth-child(3) { min-width: 150px; }
    .table th:nth-child(4) { min-width: 150px; }
    .table th:nth-child(5) { min-width: 150px; }
    .table th:nth-child(6) { min-width: 150px; }
    .table th:nth-child(7) { min-width: 100px; }
    .table th:nth-child(8) { min-width: 80px; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #718096;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .btn-primary.Validate_Receipt {
            width: 100%;
            justify-content: center;
        }
    }

    /* Loading State */
    .table tbody tr {
        transition: opacity 0.3s;
    }

    .table tbody tr.loading {
        opacity: 0.5;
    }

    /* Tooltip */
    [data-tooltip] {
        position: relative;
        cursor: help;
    }

    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: #2d3748;
        color: white;
        font-size: 12px;
        border-radius: 4px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
    }

    [data-tooltip]:hover:before {
        opacity: 1;
        visibility: visible;
    }

    /* Validation Message Styling */
    .custom-error-msg {
        padding: 15px 20px;
        margin: 0;
        display: none;
    }

    .custom-error-msg.alert {
        display: block;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .custom-error-msg.alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .custom-error-msg.alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .custom-error-msg.alert-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
    }

    .custom-error-msg.alert-info {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
    }

    /* Flash Message Styling */
    .alert {
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.5;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeeba;
        color: #856404;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }

    /* Close button for alerts */
    .alert .close {
        float: right;
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: 0.2;
        background: transparent;
        border: 0;
        padding: 0;
        cursor: pointer;
    }

    .alert .close:hover {
        opacity: 0.5;
    }

    /* Animation for alerts */
    .alert {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Filter Panel Styling */
    .filter_panel {
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filter_panel h4 {
        color: #4a5568 !important;
        font-size: 1.1rem;
        margin-bottom: 20px;
        font-weight: 600;
    }

    /* Action Button and Dropdown Styling */
    .dropdown.d-inline {
        position: relative;
    }

    .dropdown.d-inline .btn {
        min-width: 120px;
        width: auto;
        text-align: center;
        white-space: nowrap;
        overflow: visible;
        padding: 8px 16px;
    }

    .dropdown.d-inline .dropdown-menu {
        min-width: 180px;
        width: auto;
        padding: 8px 0;
        margin-top: 2px;
        right: 0;
        left: auto;
        white-space: nowrap;
        z-index: 1000;
        position: absolute;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .dropdown.d-inline .dropdown-item {
        padding: 8px 4px;
        font-size: 14px;
        color: #4a5568;
        display: flex;
        align-items: center;
        /*gap: 8px;*/
        white-space: nowrap;
        width: 100%;
    }

    .dropdown.d-inline .dropdown-item:hover {
        background-color: #f7fafc;
        color: #394eea;
    }

    .dropdown.d-inline .dropdown-item i {
        font-size: 14px;
        width: 16px;
        text-align: center;
    }

    /* Ensure table cell with dropdown has enough space */
    .table td:last-child {
        min-width: 140px;
        width: auto;
        white-space: nowrap;
    }
    .filter_panel {display: none;}
</style>
@endsection

@section('content')
<div class="main-content">
    <section class="section" style="padding-top: 40px;">
        <div class="section-body">
            @include('../Elements/flash-message')
            
            <div class="card">
                <div class="custom-error-msg">
                </div>
                <div class="card-header">
                    <h4 style="color: #4a5568 !important;">All Clients Matters</h4>
                    <a href="javascript:;" class="btn btn-theme btn-theme-sm filter_btn"><i class="fas fa-filter"></i> Filter</a>
                </div>
                
                <div class="card-body">
                    <div class="filter_panel">
                        <h4>Search By Details</h4>
                        <form action="{{URL::to('/admin/clientsmatterslist')}}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="matter" class="col-form-label" style="color:#4a5568 !important;">Matter</label>
                                        <select class="form-control select2-matter" name="sel_matter_id">
                                            <option value="">Select Matter</option>
                                            @foreach(\App\Matter::orderBy('title', 'asc')->get() as $matter)
                                            <option value="{{ $matter->id }}" {{ request('sel_matter_id') == $matter->id ? 'selected' : '' }}>{{ $matter->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pnr" class="col-form-label" style="color:#4a5568 !important;">Client ID</label>
                                        <input type="text" name="client_id" value="{{ Request::get('client_id') }}" class="form-control" data-valid="" autocomplete="off" placeholder="Client ID" id="client_id">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_name" class="col-form-label" style="color:#4a5568 !important;">Client Name</label>
                                        <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control agent_company_name" data-valid="" autocomplete="off" placeholder="Name" id="name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-theme-lg">Search</button>
                                    <a class="btn btn-info" href="{{URL::to('/admin/clientsmatterslist')}}">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Matter</th>
                                    <th>Client ID</th>
                                    <th>Client Name</th>
                                    <th>Migration Agent</th>
                                    <th>Person Responsible</th>
                                    <th>Person Assisting</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="tdata">
                                @if(@$totalData !== 0)
                                <?php $i=0; ?>
                                    @foreach (@$lists as $list)
                                        <?php
                                        $mig_agent_info = \App\Admin::select('first_name','last_name')->where('id', $list->sel_migration_agent)->first();
                                        $person_responsible = \App\Admin::select('first_name','last_name')->where('id', $list->sel_person_responsible)->first();
                                        $person_assisting = \App\Admin::select('first_name','last_name')->where('id', $list->sel_person_assisting)->first();
                                        ?>
                                        <tr id="id_{{@$list->id}}">
                                            <td class="tdCls"><a href="{{URL::to('/admin/clients/detail/'.base64_encode(convert_uuencode(@$list->client_id)).'/'.$list->client_unique_matter_no )}}">{{ @$list->title == "" ? config('constants.empty') : str_limit(@$list->title, '50', '...') }} ({{ @$list->client_unique_matter_no == "" ? config('constants.empty') : str_limit(@$list->client_unique_matter_no, '50', '...') }}) </a></td>
                                            <td class="tdCls">{{ @$list->client_unique_id == "" ? config('constants.empty') : str_limit(@$list->client_unique_id, '50', '...') }}</td>
                                            <td class="tdCls"><a href="{{URL::to('/admin/clients/detail/'.base64_encode(convert_uuencode(@$list->client_id)) )}}">{{ @$list->first_name == "" ? config('constants.empty') : str_limit(@$list->first_name, '50', '...') }} {{ @$list->last_name == "" ? config('constants.empty') : str_limit(@$list->last_name, '50', '...') }}</a></td>
                                            <td class="tdCls">{{ @$mig_agent_info->first_name == "" ? config('constants.empty') : str_limit(@$mig_agent_info->first_name, '50', '...') }} {{ @$mig_agent_info->last_name == "" ? config('constants.empty') : str_limit(@$mig_agent_info->last_name, '50', '...') }}</td>
                                            <td class="tdCls">{{ @$person_responsible->first_name == "" ? config('constants.empty') : str_limit(@$person_responsible->first_name, '50', '...') }} {{ @$person_responsible->last_name == "" ? config('constants.empty') : str_limit(@$person_responsible->last_name, '50', '...') }}</td>
                                            <td class="tdCls">{{ @$person_assisting->first_name == "" ? config('constants.empty') : str_limit(@$person_assisting->first_name, '50', '...') }} {{ @$person_assisting->last_name == "" ? config('constants.empty') : str_limit(@$person_assisting->last_name, '50', '...') }}</td>
                                            <td class="tdCls">{{date('d/m/Y', strtotime($list->created_at))}}</td>
                                            <td class="tdCls">
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item has-icon" href="javascript:;" onclick="deleteAction({{$list->id}}, 'client_matters')"><i class="fas fa-trash"></i> Close Matter</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="empty-state">
                                            <div>
                                                <i class="fas fa-inbox fa-3x mb-3" style="color: #cbd5e0;"></i>
                                                <p>No records found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer">
                    {!! $lists->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
jQuery(document).ready(function($){
	// Initialize Select2 for matter dropdown
	$('.select2-matter').select2({
		placeholder: "Select Matter",
		allowClear: true,
		width: '100%'
	});

	$('.filter_btn').on('click', function(){
		$('.filter_panel').slideToggle();
	});

	$("[data-checkboxes]").each(function () {
        var me = $(this),
        group = me.data('checkboxes'),
        role = me.data('checkbox-role');
        me.change(function () {
            var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
            checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
            dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
            total = all.length,
            checked_length = checked.length;
            if (role == 'dad') {
                if (me.is(':checked')) {
                    all.prop('checked', true);
                    $('.is_checked_clientn').hide();
                } else {
                    all.prop('checked', false);
                    $('.is_checked_clientn').show();
                }
            } else {
                if (checked_length >= total) {
                    dad.prop('checked', true);
                    $('.is_checked_clientn').hide();
                } else {
                    dad.prop('checked', false);
                    $('.is_checked_clientn').show();
                }
            }
        });
    });

    var clickedOrder = [];
    var clickedIds = [];
    $(document).delegate('.your-checkbox', 'click', function(){
        var clicked_id = $(this).data('id');
        var nameStr = $(this).attr('data-name');
        var clientidStr = $(this).attr('data-clientid');
        var finalStr = nameStr+'('+clientidStr+')'; //console.log('finalStr='+finalStr);
        if ($(this).is(':checked')) {
            clickedOrder.push(finalStr);
            clickedIds.push(clicked_id);
        } else {
            var index = clickedOrder.indexOf(finalStr);
            if (index !== -1) {
                clickedOrder.splice(index, 1);
            }
            var index1 = clickedIds.indexOf(clicked_id);
            if (index1 !== -1) {
                clickedIds.splice(index1, 1);
            }
        }
    });

    $('.cb-element').change(function () {
        if ($('.cb-element:checked').length == $('.cb-element').length){
            $('#checkbox-all').prop('checked',true);
        } else {
            $('#checkbox-all').prop('checked',false);
        }
    });

    $(document).delegate('.clientemail', 'click', function(){
        $('#emailmodal').modal('show');
        var array = [];
        var data = [];
        var id = $(this).attr('data-id');
        array.push(id);
        var email = $(this).attr('data-email');
        var name = $(this).attr('data-name');
        var status = 'Client';
        data.push({
            id: id,
            text: name,
            html:  "<div  class='select2-result-repository ag-flex ag-space-between ag-align-center'>" +

                "<div  class='ag-flex ag-align-start'>" +
                    "<div  class='ag-flex ag-flex-column col-hr-1'><div class='ag-flex'><span  class='select2-result-repository__title text-semi-bold'>"+name+"</span>&nbsp;</div>" +
                    "<div class='ag-flex ag-align-center'><small class='select2-result-repository__description'>"+email+"</small ></div>" +

                "</div>" +
                "</div>" +
                "<div class='ag-flex ag-flex-column ag-align-end'>" +

                    "<span class='ui label yellow select2-result-repository__statistics'>"+ status +

                    "</span>" +
                "</div>" +
                "</div>",
            title: name
        });
        $(".js-data-example-ajax").select2({
            data: data,
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: function(data) {
                return data.html;
            },
            templateSelection: function(data) {
                return data.text;
            }
        })
        $('.js-data-example-ajax').val(array);
        $('.js-data-example-ajax').trigger('change');
    });

    $(document).delegate('.selecttemplate', 'change', function(){
        var v = $(this).val();
        $.ajax({
            url: '{{URL::to('/admin/get-templates')}}',
            type:'GET',
            datatype:'json',
            data:{id:v},
            success: function(response){
                var res = JSON.parse(response);
                $('.selectedsubject').val(res.subject);
                $(".summernote-simple").summernote('reset');
                $(".summernote-simple").summernote('code', res.description);
                $(".summernote-simple").val(res.description);
            }
        });
    });

    $('.js-data-example-ajax').select2({
        multiple: true,
        closeOnSelect: false,
        dropdownParent: $('#emailmodal'),
        ajax: {
            url: '{{URL::to('/admin/clients/get-recipients')}}',
            dataType: 'json',
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return { results: data.items };
            },
            cache: true
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    $('.js-data-example-ajaxcc').select2({
        multiple: true,
        closeOnSelect: false,
        dropdownParent: $('#emailmodal'),
        ajax: {
            url: '{{URL::to('/admin/clients/get-recipients')}}',
            dataType: 'json',
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            },
            cache: true
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        var $container = $(
            "<div  class='select2-result-repository ag-flex ag-space-between ag-align-center'>" +

            "<div  class='ag-flex ag-align-start'>" +
                "<div  class='ag-flex ag-flex-column col-hr-1'><div class='ag-flex'><span  class='select2-result-repository__title text-semi-bold'></span>&nbsp;</div>" +
                "<div class='ag-flex ag-align-center'><small class='select2-result-repository__description'></small ></div>" +

            "</div>" +
            "</div>" +
            "<div class='ag-flex ag-flex-column ag-align-end'>" +

                "<span class='ui label yellow select2-result-repository__statistics'>" +

                "</span>" +
            "</div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.name);
        $container.find(".select2-result-repository__description").text(repo.email);
        $container.find(".select2-result-repository__statistics").append(repo.status);
        return $container;
    }

    function formatRepoSelection (repo) {
    return repo.name || repo.text;
    }
});
</script>
@endsection


