@extends('layouts.admin_client_detail')
@section('title', 'Office Check In')
@section('content')
<style>
.countAction {background: #1f1655;padding: 0px 5px;border-radius: 50%;color: #fff;margin-left: 5px;}

/* Fix for white text color in appointments table */
.card .card-body table.table {
    --bs-table-color: #000 !important;
    --bs-table-striped-color: #666 !important;
    --bs-table-active-color: #666 !important;
    --bs-table-hover-color: #666 !important;
}

.card .card-body table.table th,
.card .card-body table.table td {
    color: #666 !important;
}

.card .card-body table.table thead th {
    color: #666 !important;
    font-weight: bold;
}

.card .card-body table.table tbody td {
    color: #666 !important;
}

/* Ensure status badges are visible */
.card .card-body table.table tbody td .badge {
    color: #666 !important;
}

/* Pagination styles */
.pagination {
    justify-content: center;
    margin-top: 20px;
}

.pagination .page-link {
    color: #007bff;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}
.show {
    display: block;
}
.dropdown-content a {
    color: #666;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section" style="margin-top: 56px;">
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
							<h4 style="color:#666;">In Person</h4>
							<div class="card-header-action">
								<a href="javascript:;" class="btn btn-primary opencheckin">Create In Person</a>
							</div>
						</div>
						<div class="card-body">
                            <?php
                            if(\Auth::user()->role == 1){
                                $InPersonCount_All_type = \App\CheckinLog::where('id', '!=', '')->orderBy('created_at', 'desc')->count();

                                $InPersonCount_waiting_type = \App\CheckinLog::where('status',0)->orderBy('created_at', 'desc')->count();

                                $InPersonCount_attending_type = \App\CheckinLog::where('status',2)->orderBy('created_at', 'desc')->count();

                                $InPersonCount_completed_type = \App\CheckinLog::where('status',1)->orderBy('created_at', 'desc')->count();

                                $InPersonCount_archived_type = \App\CheckinLog::where('is_archived',1)->orderBy('created_at', 'desc')->count();

                            } else {
                                $InPersonCount_All_type = \App\CheckinLog::where('user_id',Auth::user()->id)->where('id', '!=', '')->orderBy('created_at', 'desc')->count();

                                $InPersonCount_waiting_type = \App\CheckinLog::where('user_id',Auth::user()->id)->where('status',0)->orderBy('created_at', 'desc')->count();

                                $InPersonCount_attending_type = \App\CheckinLog::where('user_id',Auth::user()->id)->where('status',2)->orderBy('created_at', 'desc')->count();

                                $InPersonCount_completed_type = \App\CheckinLog::where('user_id',Auth::user()->id)->where('status',1)->orderBy('created_at', 'desc')->count();

                                $InPersonCount_archived_type = \App\CheckinLog::where('is_archived',1)->orderBy('created_at', 'desc')->count();

                            }?>
							<ul class="nav nav-pills" id="checkin_tabs" role="tablist">

								<li class="nav-item">
									<a class="nav-link " id="waiting-tab"  href="{{URL::to('/admin/office-visits/waiting')}}" >Waiting <span class="countAction">{{ $InPersonCount_waiting_type }}</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="attending-tab"  href="{{URL::to('/admin/office-visits/attending')}}" >Attending <span class="countAction">{{ $InPersonCount_attending_type }}</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="completed-tab"  href="{{URL::to('/admin/office-visits/completed')}}" >Completed <span class="countAction">{{ $InPersonCount_completed_type }}</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" id="archived-tab"  href="{{URL::to('/admin/office-visits/archived')}}" >Archived <span class="countAction">{{ $InPersonCount_archived_type }}</span></a>
								</li>
								<li class="nav-item">
									<a class="nav-link " id="all-tab"  href="{{URL::to('/admin/office-visits')}}" >All <span class="countAction">{{ $InPersonCount_All_type }}</span></a>
								</li>
							</ul>
							<div class="tab-content" id="checkinContent">
							<div class="mydropdown" style="margin-top:10px;">
								  <button style="border: 1px solid #FFFFFF;padding: 10px 10px 10px 10px;" onclick="myFunction()" class="dropbtn">
								  <?php echo isset($_GET['office_name']) ? $_GET['office_name'] : 'All Branches'; ?>
								   <i style="font-size: 10px;" class="fa fa-arrow-down"></i></button>
								  <div id="myDropdown" class="dropdown-content">
								  <a href="{{URL::to('/admin/office-visits/archived')}}">All Branches</a>
								  <?php
								  $branchs = \App\Branch::all();
								  foreach($branchs as $branch){
									?>
									<a href="{{URL::to('/admin/office-visits/archived')}}?office={{$branch->id}}&office_name={{$branch->office_name}}">{{$branch->office_name}}</a>
								  <?php } ?>

								  </div>
								</div>
								<div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
									<div class="table-responsive common_table">
										<table class="table text_wrap">
											<thead>
												<tr>

													<th>ID</th>
													<th>Date</th>
													<th>Start</th>
													<th>End</th>
													<th>Contact Name</th>
													<th>Contact Type</th>
													<th>Visit Purpose</th>
													<th>Assignee</th>
													<th>Status</th>
												</tr>
											</thead>

											<tbody class="tdata checindata">
												@if(@$totalData !== 0)
												@foreach (@$lists as $list)
												<tr did="{{@$list->id}}" id="id_{{@$list->id}}">
													<td style="white-space: initial;"><a id="{{@$list->id}}" class="opencheckindetail" href="javascript:;">#{{$list->id}}</a></td>
													<td style="white-space: initial;"><a href="javascript:;">{{date('l',strtotime($list->created_at))}}</a><br>{{date('d/m/Y',strtotime($list->created_at))}}</td>
													<td style="white-space: initial;"><?php if($list->sesion_start != ''){ echo date('h:i A',strtotime($list->sesion_start)); }else{ echo '-'; } ?></td>
													<td style="white-space: initial;"><?php if($list->sesion_end != ''){ echo date('h:i A',strtotime($list->sesion_end)); }else{ echo '-'; } ?></td>

												<td style="white-space: initial;">
													<?php
													if($list->contact_type == 'Lead'){
												$client = \App\Lead::where('id', '=', $list->client_id)->first();
												 ?>
										    <a href="{{URL::to('/admin/leads/history/'.base64_encode(convert_uuencode(@$client->id)))}}">{{@$client->first_name}} {{@$client->last_name}}</a>
										    <?php
										}else{
										    $client = \App\Admin::where('role', '=', '7')->where('id', '=', $list->client_id)->first();
										    ?>
										    <a href="{{URL::to('/admin/clients/detail/'.base64_encode(convert_uuencode(@$client->id)))}}">{{@$client->first_name}} {{@$client->last_name}}</a>
										    <?php
										}

													?>
													<br>{{@$client->email}}
													</td>
													<td style="white-space: initial;">{{$list->contact_type}}</td>
													<td style="white-space: initial;">{{$list->visit_purpose}}</td>
													<td style="white-space: initial;">
													<?php
													$admin = \App\Admin::where('role', '!=', '7')->where('id', '=', $list->user_id)->first();
													?>
													<a href="{{URL::to('/admin/users/view/'.@$admin->id)}}">{{@$admin->first_name}} {{@$admin->last_name}}</a><br>{{@$admin->email}}
													</td>
													<td ><?php
													if($list->status == 0){
														?>
														<span class="text-warning">Waiting</span>
														<?php
													}else if($list->status == 2){
														?>
														<span class="text-info">Attending</span>
														<?php
													}else if($list->status == 1){
														?>
														<span class="text-success">Completed</span>
														<?php
													}
													?></td>
												</tr>
												@endforeach
											</tbody>
											@else
											<tbody>
												<tr>
													<td style="text-align:center;" colspan="10">
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
						<div class="card-footer">
							{!! $lists->appends(\Request::except('page'))->render() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade clientemail custom_modal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="clientModalLabel">Compose Email</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" autocomplete="off" enctype="multipart/form-data">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="email_from">From <span class="span_req">*</span></label>
								<input type="text" name="email_from" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter From">
								@if ($errors->has('email_from'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('email_from') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="email_to">To <span class="span_req">*</span></label>
								<input type="text" name="email_to" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter To">
								@if ($errors->has('email_to'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('email_to') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="subject">Subject <span class="span_req">*</span></label>
								<input type="text" name="subject" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Subject">
								@if ($errors->has('subject'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('subject') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="message">Message <span class="span_req">*</span></label>
								<textarea class="summernote-simple" name="message"></textarea>
								@if ($errors->has('message'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('message') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<button type="submit" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
jQuery(document).ready(function($){
    $(document).delegate('.openassignee', 'click', function(){
        $('.assignee').show();
    });
     $(document).delegate('.closeassignee', 'click', function(){
        $('.assignee').hide();
    });
     $(document).delegate('.saveassignee', 'click', function(){
        var appliid = $(this).attr('data-id');
		$('.popuploader').show();
		$.ajax({
			url: site_url+'/admin/office-visits/change_assignee',
			type:'GET',
			data:{id: appliid,assinee: $('#changeassignee').val()},
			success: function(response){

				 var obj = $.parseJSON(response);
				if(obj.status){
				    alert(obj.message);
				location.reload();

				}else{
					alert(obj.message);
				}
			}
		});
    });
});
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
@endsection
