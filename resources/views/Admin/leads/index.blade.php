@extends('layouts.admin_client_detail')
@section('title', 'Leads')

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
        border-bottom: 1px solidrgb(27, 4, 4);
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
        position: relative;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow-x: auto;
        box-shadow: 0 0 0 1px #f0f0f0;
        position: relative;
        width: 100%;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.875rem;
        margin: 0;
        position: relative;
        table-layout: fixed;
    }

    .table thead th {
        background: #f8fafc;
        color: #4a5568 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 12px 8px;
        border-bottom: 2px solid #edf2f7;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table tbody td {
        padding: 12px 8px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568 !important;
        vertical-align: middle;
        transition: all 0.2s;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
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

    /* Table cell styling for better text wrapping */
    .table td {
        white-space: normal;
        word-wrap: break-word;
        max-width: 0;
        padding: 12px 8px;
        vertical-align: middle;
    }

    /* Client ID specific styling */
    .table td:nth-child(6) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Ensure table headers don't wrap */
    .table th {
        white-space: nowrap;
        padding: 12px 8px;
    }

    /* Add minimum width to prevent columns from becoming too narrow */
    .table th:nth-child(1) { min-width: 50px; } /* Checkbox */
    .table th:nth-child(2) { min-width: 150px; } /* Name */
    .table th:nth-child(3) { min-width: 80px; } /* Agent */
    .table th:nth-child(4) { min-width: 80px; } /* Tag(s) */
    .table th:nth-child(5) { min-width: 50px; } /* Rating */
    .table th:nth-child(6) { min-width: 120px; } /* Client ID */
    .table th:nth-child(7) { min-width: 100px; } /* Current City */
    .table th:nth-child(8) { min-width: 100px; } /* Assignee */
    .table th:nth-child(9) { min-width: 100px; } /* Followers */
    .table th:nth-child(10) { min-width: 80px; } /* Status */
    .table th:nth-child(11) { min-width: 80px; } /* Applications */
    .table th:nth-child(12) { min-width: 80px; } /* Last Updated */
    .table th:nth-child(13) { min-width: 100px; } /* Preferred Intake */
    .table th:nth-child(14) { min-width: 120px; } /* Action */

    /* Column width adjustments */
    .table th:nth-child(1),
    .table td:nth-child(1) { width: 4%; } /* Checkbox */
    .table th:nth-child(2),
    .table td:nth-child(2) { width: 12%; } /* Name */
    .table th:nth-child(3),
    .table td:nth-child(3) { width: 6%; } /* Agent */
    .table th:nth-child(4),
    .table td:nth-child(4) { width: 6%; } /* Tag(s) */
    .table th:nth-child(5),
    .table td:nth-child(5) { width: 4%; } /* Rating */
    .table th:nth-child(6),
    .table td:nth-child(6) { width: 10%; } /* Client ID */
    .table th:nth-child(7),
    .table td:nth-child(7) { width: 8%; } /* Current City */
    .table th:nth-child(8),
    .table td:nth-child(8) { width: 8%; } /* Assignee */
    .table th:nth-child(9),
    .table td:nth-child(9) { width: 8%; } /* Followers */
    .table th:nth-child(10),
    .table td:nth-child(10) { width: 7%; } /* Status */
    .table th:nth-child(11),
    .table td:nth-child(11) { width: 7%; } /* Applications */
    .table th:nth-child(12),
    .table td:nth-child(12) { width: 7%; } /* Last Updated */
    .table th:nth-child(13),
    .table td:nth-child(13) { width: 8%; } /* Preferred Intake */
    .table th:nth-child(14),
    .table td:nth-child(14) { width: 11%; } /* Action */

    /* Tab Styling */
    .nav-pills .nav-link {
        color: #4a5568;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-right: 5px;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .nav-pills .nav-link:hover {
        background-color: #edf2f7;
        color: #2d3748;
    }

    .nav-pills .nav-link.active {
        background-color: #394eea;
        color: white;
        border-color: #394eea;
    }

    .nav-pills {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
    }

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
        .table th:nth-child(1),
        .table td:nth-child(1) { width: 5%; }
        .table th:nth-child(2),
        .table td:nth-child(2) { width: 15%; }
        .table th:nth-child(6),
        .table td:nth-child(6) { width: 12%; }
    }

    @media (max-width: 992px) {
        .table th:nth-child(1),
        .table td:nth-child(1) { width: 6%; }
        .table th:nth-child(2),
        .table td:nth-child(2) { width: 18%; }
        .table th:nth-child(6),
        .table td:nth-child(6) { width: 15%; }
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
        display: none;
    }

    .filter_panel h4 {
        color: #4a5568 !important;
        font-size: 1.1rem;
        margin-bottom: 20px;
        font-weight: 600;
    }

    /* Action Button and Dropdown Styling */
    .table td:last-child {
        position: relative;
        min-width: 120px;
    }

    .table td .dropdown.d-inline {
        position: relative;
        display: inline-block;
    }

    .table td .dropdown-toggle.btn-primary {
        background: #394eea;
        border-color: #394eea;
        min-width: 100px;
        padding: 6px 12px;
        font-size: 14px;
    }

    .table td .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
        float: left;
        min-width: 160px;
        padding: 5px 0;
        margin: 2px 0 0;
        font-size: 14px;
        text-align: left;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        background-clip: padding-box;
        z-index: 9999;
    }

    .table td .dropdown-menu.show {
        display: block;
        transform: none !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
    }

    .table td .dropdown-item {
        display: flex !important;
        align-items: center !important;
        padding: 8px 16px !important;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .table td .dropdown-item:hover {
        background-color: #f5f5f5;
        color: #262626;
        text-decoration: none;
    }

    .table td .dropdown-item i {
        margin-right: 8px;
        width: 16px;
        text-align: center;
    }

    /* Table container */
    .table-responsive {
        position: relative;
        overflow-x: auto !important;
    }

    .card-body {
        position: relative;
        overflow: visible;
    }

    /* Override any Bootstrap positioning */
    .table td .dropdown-menu[style*="transform"],
    .table td .dropdown-menu[style*="position"] {
        position: absolute !important;
        transform: none !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
    }

    /* Ensure dropdown stays within viewport */
    @media screen and (max-width: 768px) {
        .table td .dropdown-menu {
            right: 0;
            left: auto;
        }
    }

    /* Status and Client ID Styling */
    .ag-label--circular {
        display: inline-block;
        padding: 4px 8px;
        /*border-radius: 12px;
        background-color: #e6f0ff;*/
        color: #394eea !important;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Client ID cell styling */
    .table td:nth-child(6) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 0;
    }

    /* Status cell styling */
    .table td:nth-child(10) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 0;
    }

    /* Ensure all cells have proper text overflow */
    .table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 0;
    }

    /* Column width adjustments */
    .table th:nth-child(1) { width: 4%; } /* Checkbox */
    .table th:nth-child(2) { width: 12%; } /* Name */
    .table th:nth-child(3) { width: 6%; } /* Agent */
    .table th:nth-child(4) { width: 6%; } /* Tag(s) */
    .table th:nth-child(5) { width: 6%; } /* Rating */
    .table th:nth-child(6) { width: 10%; } /* Client ID */
    .table th:nth-child(7) { width: 8%;white-space: initial; } /* Current City */
    .table th:nth-child(8) { width: 8%; } /* Assignee */
    .table th:nth-child(9) { width: 8%; } /* Followers */
    .table th:nth-child(10) { width: 7%; } /* Status */
    .table th:nth-child(11) { width: 7%;white-space: initial; } /* Applications */
    .table th:nth-child(12) { width: 7%;white-space: initial; } /* Last Updated */
    .table th:nth-child(13) { width: 8%;white-space: initial; } /* Preferred Intake */
    .table th:nth-child(14) { width: 11%; } /* Action */

</style>
@endsection

@section('content')
<div class="main-content">
    <section class="section" style="padding-top: 60px;">
        <div class="section-body">
            @include('../Elements/flash-message')

            <div class="card">
                <div class="custom-error-msg">
                </div>
                <div class="card-header">
                    <h4 style="color: #4a5568 !important;">All Leads</h4>

                    <!--<div class="d-flex align-items-center">
						<a href="{{--route('admin.leads.create')--}}" class="btn btn-primary">Create Lead</a>
                    </div>-->
                </div>

                <div class="card-body">
					<ul class="nav nav-pills" id="client_tabs" role="tablist">
						<li class="nav-item is_checked_client" style="display:none;">
							<a class="btn btn-primary emailmodal" id=""  href="javascript:;"  >Send Mail</a>
						</li>
						<li class="nav-item is_checked_client" style="display:none;">
							<a class="btn btn-primary " id=""  href="javascript:;"  >Change Assignee</a>
						</li>

						<li class="nav-item is_checked_client_merge" style="display:none;">
							<a class="btn btn-primary " id=""  href="javascript:;"  >Merge</a>
						</li>

						<li class="nav-item is_checked_clientn">
							<a class="nav-link " id="clients-tab"  href="{{URL::to('/admin/clients')}}" >Clients</a>
						</li>
						<li class="nav-item is_checked_clientn">
							<a class="nav-link" id="archived-tab"  href="{{URL::to('/admin/archived')}}" >Archived</a>
						</li>
						<li class="nav-item is_checked_clientn">
							<a class="nav-link active" id="lead-tab"  href="{{URL::to('/admin/leads')}}" >Leads</a>
						</li>

                        <li>
							<a style="padding: 10px 10px 10px 10px;" href="{{route('admin.leads.create')}}" class="btn btn-primary">Create Lead</a>
						</li>
					</ul>


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
								<tr>
									<th class="text-center">
										<div class="custom-checkbox custom-checkbox-table custom-control">
											<input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
											<label for="checkbox-all" class="custom-control-label">&nbsp;</label>
										</div>
									</th>
									<th>Name</th>
									<th>Info</th>
									<th>Contact Date</th>
									<th>Level & Status</th>
									<th>Followup</th>
									<th>Action</th>
								</tr>
                            </thead>
							<tbody class="tdata">
								@if(@$totalData !== 0)
								<?php $i = 0; ?>
								@foreach (@$lists as $list)
									<?php
									$followpe = \App\Followup::where('lead_id', '=', $list->id)
									->where('followup_type', '!=', 'assigned_to')
									->orderby('id', 'DESC')
									->with(['followutype'])
									->first();
									$followp = \App\Followup::where('lead_id', '=', $list->id)
									->where('followup_type', '=', 'follow_up')
									->orderby('id', 'DESC')
									->with(['followutype'])
									->first();
									?>
									<tr id="id_{{@$list->id}}">
										<td style="white-space: initial;" class="text-center">
											<div class="custom-checkbox custom-control">
												<input data-id="{{@$list->id}}" data-email="{{@$list->email}}" data-name="{{@$list->first_name}} {{@$list->last_name}}" data-clientid="{{@$list->client_id}}" type="checkbox" data-checkboxes="mygroup" class="cb-element custom-control-input  your-checkbox" id="checkbox-{{$i}}">
												<label for="checkbox-{{$i}}" class="custom-control-label">&nbsp;</label>
											</div>
										</td>
										<td style="white-space: initial;">
											<a href="{{ URL::to('/admin/clients/detail/' . base64_encode(convert_uuencode(@$list->id))) }}">
												{{ @$list->first_name == "" ? config('constants.empty') : str_limit(@$list->first_name, '50', '...') }}
												{{ @$list->last_name == "" ? config('constants.empty') : str_limit(@$list->last_name, '50', '...') }}
											</a>

										</td>
										<td><i class="fa fa-mobile"></i> {{@$list->phone}} <br/> <i class="fa fa-envelope"></i> {{@$list->email}}</td>
										<td>{{@$list->service}} <br/> {{date('d/m/Y h:i:s a', strtotime($list->created_at))}}</td>
										<td><div class="lead_stars"><i class="fa fa-star"></i><span>{{@$list->lead_quality}}</span> {{@$followpe->followutype->name}}</div></td>
										@if($followp)
											@if(@$followp->followutype->type == 'follow_up')
												<td>{{$followp->followutype->name}}<br> {{date('d/m/Y h:i:s a', strtotime($followp->followup_date))}}</td>
											@else
												<td>{{@$followp->followutype->name}}</td>
											@endif
										@else
											<td>Not Contacted</td>
										@endif
										<td>
											<div class="dropdown action_toggle">
												<a class="dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="more-vertical"></i></a>
												<div class="dropdown-menu">
													<a class="dropdown-item has-icon" href="{{URL::to('/admin/clients/edit/'.base64_encode(convert_uuencode(@$list->id)))}}">
														<i class="fa fa-edit"></i> Edit
													</a>
												</div>
											</div>
										</td>
									</tr>
									<?php $i++; ?>
								@endforeach

								@else
									<tr>
										<td style="text-align:center;" colspan="10">
											No Record found
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

<div class="modal fade" id="assignlead_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				  <h4 class="modal-title">Assign Lead</h4>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
			</div>
			<form action="{{ url('admin/leads/assign') }}" method="POST" name="add-assign" autocomplete="off" enctype="multipart/form-data" id="addnoteform">
    @csrf
    <div class="modal-body">
        <div class="form-group row">
            <div class="col-sm-12">
                <input id="mlead_id" name="mlead_id" type="hidden" value="">
                <select name="assignto" class="form-control select2 " style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value="">Select</option>
                    @foreach(\App\Admin::Where('role', '!=', '7')->get() as $ulist)
                    <option value="{{@$ulist->id}}">{{@$ulist->first_name}} {{@$ulist->last_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" onClick='customValidate("add-assign")'>
            <i class="fa fa-save"></i> Assign Lead
        </button>
    </div>
</form>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script>
    jQuery(document).ready(function($){
        $('.filter_btn').on('click', function(){
		$('.filter_panel').slideToggle();
	});
         $('.assignlead_modal').on('click', function(){
			  var val = $(this).attr('mleadid');
			  $('#assignlead_modal #mlead_id').val(val);
			  $('#assignlead_modal').modal('show');
		  });
    });
</script>
@endsection

