@extends('layouts.admin')
@section('title', 'Client Reports')

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
							<h4>Client Reports</h4>
							<div class="card-header-action">
								<div class="drop_table_data" style="display: inline-block;margin-right: 10px;">
									<button type="button" class="btn btn-primary dropdown-toggle"><i class="fas fa-columns"></i></button>
									<div class="dropdown_list client_report_list">
										<label class="dropdown-option all"><input type="checkbox" value="all" checked /> Display All</label>
										<label class="dropdown-option"><input type="checkbox" value="3" checked /> Rating</label>
										<label class="dropdown-option"><input type="checkbox" value="5" checked /> Status</label>
										<label class="dropdown-option"><input type="checkbox" value="4" checked /> Client Id</label>
										<label class="dropdown-option"><input type="checkbox" value="6" checked /> Added From</label>
										<label class="dropdown-option"><input type="checkbox" value="7" checked /> Tag(s)</label>
										<label class="dropdown-option"><input type="checkbox" value="8" checked /> Sub Agent</label>
										<label class="dropdown-option"><input type="checkbox" value="9" checked /> Contact Source</label>
										<label class="dropdown-option"><input type="checkbox" value="10" checked /> Phone</label>
										<label class="dropdown-option"><input type="checkbox" value="12" checked /> Street</label>
										<label class="dropdown-option"><input type="checkbox" value="13" checked /> City</label>
										<label class="dropdown-option"><input type="checkbox" value="14" checked /> State</label>
										<label class="dropdown-option"><input type="checkbox" value="15" checked /> Country</label>
										<label class="dropdown-option"><input type="checkbox" value="16" checked /> Country Of Passport</label>
										<label class="dropdown-option"><input type="checkbox" value="17" checked /> D.O.B</label>
										<label class="dropdown-option"><input type="checkbox" value="18" checked /> Added Date</label>
										<label class="dropdown-option"><input type="checkbox" value="19" checked /> Enquiry Date</label>
										<label class="dropdown-option"><input type="checkbox" value="20" checked /> Prospect Date</label>
										<label class="dropdown-option"><input type="checkbox" value="21" checked /> Client Date</label>
										<label class="dropdown-option"><input type="checkbox" value="22" checked /> Visa Expiry Date</label>
										<label class="dropdown-option"><input type="checkbox" value="23" checked /> Preferred Intake</label>
										<label class="dropdown-option"><input type="checkbox" value="25" checked /> Added By Office</label>
										<label class="dropdown-option"><input type="checkbox" value="24" checked /> Added By User</label>
										<label class="dropdown-option"><input type="checkbox" value="26" checked /> Assignee</label>
										<label class="dropdown-option"><input type="checkbox" value="27" checked /> Assignee Office</label>
										<label class="dropdown-option"><input type="checkbox" value="28" checked /> Followers</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive common_table client_report_data">
								<table class="table text_wrap">
									<thead>
										<tr>
											<th class="text-center" style="width:30px;">
												<div class="custom-checkbox custom-checkbox-table custom-control">
													<input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
													<label for="checkbox-all" class="custom-control-label">&nbsp;</label>
												</div>
											</th>
											<th>Client</th>
											<th>Rating</th>
											<th>Client ID</th>
											<th>Status</th>
											<th>Added From</th>
											<th>Tag(s)</th>
											<th>Sub Agent</th>
											<th>Contact Source</th>
											<th>Phone</th>
											<th>Email</th>
											<th>Street</th>
											<th>City</th>
											<th>State</th>
											<th>Country</th>
											<th>Country Of Passport</th>
											<th>D.O.B</th>
											<th>Added Date</th>
											<th>Enquiry Date</th>
											<th>Prospect Date</th>
											<th>Client Date</th>
											<th>Visa Expiry Date</th>
											<th>Preferred Intake</th>
											<th>Added By User</th>
											<th>Added By Office</th>
											<th>Assignee</th>
											<th>Assignee Office</th>
											<th>Followers</th>
										</tr>
									</thead>
									@if(count($lists) >0)
									<tbody class="tdata">
										@if(@$totalData !== 0)
										<?php $i=0; ?>
										@foreach (@$lists as $list)
										<tr id="id_{{@$list->id}}">
											<td class="text-center">
												<div class="custom-checkbox custom-control">
													<input data-id="{{@$list->id}}" data-email="{{@$list->email}}" data-name="{{@$list->first_name}} {{@$list->last_name}}" type="checkbox" data-checkboxes="mygroup" class="cb-element custom-control-input" id="checkbox-{{$i}}">
													<label for="checkbox-{{$i}}" class="custom-control-label">&nbsp;</label>
												</div>
											</td>
											<td>{{ @$list->first_name == "" ? config('constants.empty') : str_limit(@$list->first_name, '50', '...') }} {{ @$list->last_name == "" ? config('constants.empty') : str_limit(@$list->last_name, '50', '...') }}</td>
											<td>{{ @$list->rating == "" ? config('constants.empty') : str_limit(@$list->rating, '50', '...') }} </td>
											<td>{{ @$list->client_id == "" ? config('constants.empty') : str_limit(@$list->client_id, '50', '...') }} </td>
											<td>{{ @$list->status == "" ? config('constants.empty') : str_limit(@$list->status, '50', '...') }} </td>
											<td>-</td>
											<td>{{ @$list->tags == "" ? config('constants.empty') : str_limit(@$list->tags, '50', '...') }}</td>
											<td>-</td>
											<td>{{ @$list->source == "" ? config('constants.empty') : str_limit(@$list->source, '50', '...') }}</td>
											<td>{{ @$list->phone == "" ? config('constants.empty') : str_limit(@$list->phone, '50', '...') }}</td>
											<td><a data-id="{{@$list->id}}" data-email="{{@$list->email}}" data-name="{{@$list->first_name}} {{@$list->last_name}}" href="javascript:;" class="clientemail">{{ @$list->email == "" ? config('constants.empty') : str_limit(@$list->email, '50', '...') }}</a></td>
											<td>{{ @$list->address == "" ? config('constants.empty') : str_limit(@$list->address, '50', '...') }}</td>
											<td>{{ @$list->city == "" ? config('constants.empty') : str_limit(@$list->city, '50', '...') }}</td>
											<td>{{ @$list->state == "" ? config('constants.empty') : str_limit(@$list->state, '50', '...') }}</td>
											<td>{{ @$list->country == "" ? config('constants.empty') : str_limit(@$list->country, '50', '...') }}</td>
											<td>{{ @$list->country_passport == "" ? config('constants.empty') : str_limit(@$list->country_passport, '50', '...') }}</td>
											<td>{{ @$list->dob == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->dob)) }}</td>
											<td>{{ @$list->created_at == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->created_at)) }}</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>{{ @$list->visaExpiry == "" ? config('constants.empty') : date('d/m/Y',strtotime(@$list->visaExpiry))  }}</td>
											<td>{{ @$list->preferredIntake == "" ? config('constants.empty') : str_limit(@$list->preferredIntake, '50', '...') }}</td>
											<td>-</td>
											<td>-</td>
											<td>{{ @$list->assignee == "" ? config('constants.empty') : str_limit(@$list->assignee, '50', '...') }}</td>
											<td>-</td>
											<td>{{ @$list->followers == "" ? config('constants.empty') : str_limit(@$list->followers, '50', '...') }}</td>
										</tr>
										<?php $i++; ?>
										@endforeach
										@endif
									</tbody>
									@else
										<tbody>
											<tr>
												<td style="text-align:center;" colspan="18">
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
