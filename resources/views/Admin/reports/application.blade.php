@extends('layouts.admin')
@section('title', 'Application Reports')

@section('content')

<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-body">
			<div class="server-error">
				@include('../Elements/flash-message')
			</div>
			<div class="custom-error-msg">
			</div>
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4>Application Reports</h4>
							<div class="card-header-action">
								<div class="drop_table_data" style="display: inline-block;margin-right: 10px;">
									<button type="button" class="btn btn-primary dropdown-toggle"><i class="fas fa-columns"></i></button>
									<div class="dropdown_list application_report_list">
										<label class="dropdown-option all"><input type="checkbox" value="all" checked /> Display All</label>
										<label class="dropdown-option"><input type="checkbox" value="4" checked /> Intake Date</label>
										<label class="dropdown-option"><input type="checkbox" value="6" checked /> Internal Client ID</label>
										<label class="dropdown-option"><input type="checkbox" value="8" checked /> DOB</label>
										<label class="dropdown-option"><input type="checkbox" value="9" checked /> Client Phone</label>
										<label class="dropdown-option"><input type="checkbox" value="10" checked /> Client Followers</label>
										<label class="dropdown-option"><input type="checkbox" value="11" checked /> Partner's Client ID</label>
										<label class="dropdown-option"><input type="checkbox" value="12" checked /> Workflow</label>
										<label class="dropdown-option"><input type="checkbox" value="13" checked /> Partner</label>
										<label class="dropdown-option"><input type="checkbox" value="14" checked /> Product</label>
										<label class="dropdown-option"><input type="checkbox" value="15" checked /> Partner Branch</label>
										<label class="dropdown-option"><input type="checkbox" value="16" checked /> Duration</label>
										<label class="dropdown-option"><input type="checkbox" value="17" checked /> Total Fee</label>
										<label class="dropdown-option"><input type="checkbox" value="18" checked /> Total Fee Discount</label>
										<label class="dropdown-option"><input type="checkbox" value="19" checked /> Installment Type</label>
										<label class="dropdown-option"><input type="checkbox" value="20" checked /> Net First Installment Amount</label>
										<label class="dropdown-option"><input type="checkbox" value="21" checked /> Status</label>
										<label class="dropdown-option"><input type="checkbox" value="22" checked /> Application In Queue</label>
										<label class="dropdown-option"><input type="checkbox" value="23" checked /> Stage In Queue</label>
										<label class="dropdown-option"><input type="checkbox" value="24" checked /> Discontinue Reason</label>
										<label class="dropdown-option"><input type="checkbox" value="25" checked /> Stage</label>
										<label class="dropdown-option"><input type="checkbox" value="26" checked /> Assignee</label>
										<label class="dropdown-option"><input type="checkbox" value="27" checked /> Started By</label>
										<label class="dropdown-option"><input type="checkbox" value="28" checked /> Office</label>
										<label class="dropdown-option"><input type="checkbox" value="29" checked /> Client Source</label>
										<label class="dropdown-option"><input type="checkbox" value="30" checked /> Sub Agent</label>
										<label class="dropdown-option"><input type="checkbox" value="31" checked /> Super Agent</label>
										<label class="dropdown-option"><input type="checkbox" value="32" checked /> Visa Expiry</label>
										<label class="dropdown-option"><input type="checkbox" value="33" checked /> Added Date</label>
										<label class="dropdown-option"><input type="checkbox" value="34" checked /> Start Date</label>
										<label class="dropdown-option"><input type="checkbox" value="35" checked /> End Date</label>
										<label class="dropdown-option"><input type="checkbox" value="36" checked /> Last Updated</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive common_table application_report_data">
								<table class="table text_wrap">
									<thead>
										<tr>
											<th class="text-center" style="width:30px;">
												<div class="custom-checkbox custom-checkbox-table custom-control">
													<input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
													<label for="checkbox-all" class="custom-control-label">&nbsp;</label>
												</div>
											</th>
											<th>Application ID</th>
											<th>Client</th>
											<th>Intake Date</th>
											<th>Email</th>
											<th>Internal Client ID</th>
											<th>Client ID</th>
											<th>D.O.B</th>
											<th>Client Phone</th>
											<th>Client Followers</th>
											<th>Partner's Client ID</th>
											<th>Workflow</th>
											<th>Partner</th>
											<th>Product</th>
											<th>Partner Branch</th>
											<th>Duration</th>
											<th>Total Fee</th>
											<th>Total Fee Discount</th>
											<th>Installment Type</th>
											<th>Net First Installment Amount</th>
											<th>Status</th>
											<th>Application In Queue</th>
											<th>Stage In Queue</th>
											<th>Discontinue Reason</th>
											<th>Stage</th>
											<th>Assignee</th>
											<th>Started By</th>
											<th>Office</th>
											<th>Client Source</th>
											<th>Sub Agent</th>
											<th>Super Agent</th>
											<th>Visa Expiry</th>
											<th>Added Date</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Last Updated</th>
										</tr>
									</thead>
									@if(count($lists) >0)
									<tbody class="tdata">
										@if(@$totalData !== 0)
										<?php $i=0; ?>
										@foreach (@$lists as $list)
										<?php
											$productdetail = \App\Product::where('id', $list->product_id)->first();
											$partnerdetail = \App\Partner::where('id', $list->partner_id)->first();
											$clientdetail = \App\Admin::where('id', $list->client_id)->first();
											$PartnerBranch = \App\PartnerBranch::where('id', $list->branch)->first();
										?>
										<tr id="id_{{@$list->id}}">
											<td class="text-center">
												<div class="custom-checkbox custom-control">
													<input data-id="{{@$list->id}}" data-email="{{@$list->email}}" data-name="{{@$list->first_name}} {{@$list->last_name}}" type="checkbox" data-checkboxes="mygroup" class="cb-element custom-control-input" id="checkbox-{{$i}}">
													<label for="checkbox-{{$i}}" class="custom-control-label">&nbsp;</label>
												</div>
											</td>
											<td><a href="{{URL::to('admin/clients/detail/')}}/{{base64_encode(convert_uuencode(@$clientdetail->id))}}?tab=application&appid={{@$list->id}}">{{ @$list->id == "" ? config('constants.empty') : str_limit(@$list->id, '50', '...') }}</a></td>
											<td><a href="{{URL::to('admin/clients/detail/')}}/{{base64_encode(convert_uuencode(@$clientdetail->id))}}">{{@$clientdetail->first_name}} {{@$clientdetail->last_name}}</a></td>
											<td>{{ @$list->intakedate == "" ? config('constants.empty') : str_limit(@$list->intakedate, '50', '...') }} </td>
											<td><a data-id="{{@$list->id}}" data-email="{{@$clientdetail->email}}" data-name="{{@$clientdetail->first_name}} {{@$clientdetail->last_name}}" href="javascript:;" class="clientemail">{{ @$clientdetail->email == "" ? config('constants.empty') : str_limit(@$clientdetail->email, '50', '...') }}</a></td>
											<td>-</td>
											<td>{{@$clientdetail->client_id}} </td>
											<td>{{date('d/m/Y',strtotime(@$clientdetail->dob))}}</td>
											<td>{{@$clientdetail->phone}} </td>
											<td>{{@$clientdetail->followers}} </td>
											<td>-</td>
											<td>{{ @$list->workflow == "" ? config('constants.empty') : str_limit(@$list->workflow, '50', '...') }} </td>
											<td>{{@$partnerdetail->partner_name}}</td>
											<td>{{@$productdetail->name}}</td>
											<td>{{$PartnerBranch->name}}</td>
											<td>{{@$productdetail->duration}}</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>{{ @$list->status == "" ? config('constants.empty') : str_limit(@$list->status, '50', '...') }} </td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>{{ @$list->stage == "" ? config('constants.empty') : str_limit(@$list->stage, '50', '...') }} </td>
											<td>{{@$clientdetail->assignee}} </td>
											<td>{{ @$list->created_at == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->created_at)) }}</td>
											<td>{{$PartnerBranch->name}}</td>
											<td>{{@$clientdetail->source}} </td>
											<td>{{ @$list->sub_agent == "" ? config('constants.empty') : str_limit(@$list->sub_agent, '50', '...') }}</td>
											<td>{{ @$list->super_agent == "" ? config('constants.empty') : str_limit(@$list->super_agent, '50', '...') }}</td>
											<td>{{date('d/m/Y',strtotime(@$clientdetail->visaExpiry))}}</td>
											<td>{{ @$list->created_at == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->created_at)) }}</td>
											<td>{{ @$list->start_date == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->start_date)) }}</td>
											<td>{{ @$list->end_date == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->end_date)) }}</td>
											<td>{{ @$list->updated_at == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->updated_at))}}</td>
										</tr>
										<?php $i++; ?>
										@endforeach
										@endif
									</tbody>
									@else
										<tbody>
											<tr>
												<td style="text-align:center;" colspan="12">
													No Record found
												</td>
											</tr>
										</tbody>
									@endif
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection
