@extends('layouts.admin')
@section('title', 'assignees')

@section('content')
<style>
.fc-event-container .fc-h-event{cursor:pointer;}
#openassigneview .modal-body ul.navbar-nav li .dropdown-menu{transform: none!important; top:40px!important;}
.sort_col a { color: #212529 !important; font-weight: 700 !important;}
</style>
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
							<h4>Assignee's</h4>
							<div class="card-header-action">
								<!-- <a href="{{URL::to('admin/quotations/template/create')}}"  class="btn btn-primary is_checked_clientn">Create Template</a> -->
							</div>

                            <ul class="nav nav-pills" id="client_tabs" role="tablist">
                                <li class="nav-item is_checked_clientn">
									<a class="nav-link active" id="clients-tab"  href="{{URL::to('/admin/assignee')}}">Incomplete</a>
								</li>
								<li class="nav-item is_checked_clientn11">
									<a class="nav-link" id="archived-tab"  href="{{URL::to('/admin/assignee-completed')}}">Completed</a>
								</li>


                                <!--<li class="nav-item is_checked_clientn12">
									<a class="nav-link" id="assigned_by_me"  href="{{URL::to('/admin/assigned_by_me')}}">Assigned by me</a>
								</li>

								<li class="nav-item is_checked_clientn13">
									<a class="nav-link" id="assigned_to_me"  href="{{URL::to('/admin/assigned_to_me')}}">Assigned to me</a>
								</li>-->
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="quotationContent">
                                <!--<div class="filter_panel">
                                    <form action="{{-- route('assignee.index') --}}" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {{-- Form::text('name',Request::get('name'),array('class'=>'form-controlagent_company_name','data-valid'=>'','autocomplete'=>'off','placeholder'=>'Assigneename','id'=>'name')) --}}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                {{-- Form::submit('Search',['class'=>'btnbtn-primarybtn-theme-lg']) --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>-->

							<form action="{{ route('assignee.index') }}" method="get">
								<div class="row">
									<div class="col-md-3">
										<!-- <select  class="form-control mb-3" name="filter">
										<option>All assignees</option>
										<option value="today">Today</option>
										<option value="last week">Last Week</option>
										<option value="previous month">Previous Month</option>
										<option value="last 6 month">Last 6 Months</option>
										<option value="last year">Last Year</option>
										</select> -->
									</div>
									{{-- <div class="col-md-3">
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control mb-3 ml-4" placeholder="Searching...." name="q">
									</div>
									<div class="col-md-2">
										<input type="submit" class="form-control mb-3 btn btn-primary" value="Search">
									</div> --}}
								</div>
							</form>
								<div class="tab-pane fade show active" id="active_quotation" role="tabpanel" aria-labelledby="active_quotation-tab">
									<div class="table-responsive common_table">
									<!-- @if ($message = Session::get('success'))
										<div class="alert alert-success">
											<p>{{ $message }}</p>
										</div>
									@endif   -->
									<table class="table table-bordered">
										<tr>
											<th>#</th>
											<th class="sort_col">@sortablelink('first_name','Assignee name')</th>
                                            <th>Assigner name</th>
											<th>Client Reference</th>
											<th class="sort_col">@sortablelink('followup_date','Follow-up')</th>
                                            <th class="sort_col">@sortablelink('task_group','Group')</th>
                                            <th>Note</th>
                                            <th width="280px">Action</th>

                                            <!--<th>Title</th>-->
											{{-- <th>Nature of enquiry</th> --}}
											<!--<th>Service</th>-->
                                            <!--<th>status</th>-->
                                        </tr>
                                        <?php //echo "<pre>assignees==";print_r($assignees);die; ?>
										@foreach ($assignees as $list)
                                        <?php //echo "<pre>list==";print_r($list);?>
										<tr>
                                            <?php
												if($list->noteClient){
													$user_name=$list->noteClient->first_name.' '.$list->noteClient->last_name;
												}else{
													$user_name='N/P';
												}
											?>
											<td>{{ ++$i }}</td>
											<td>{{ $list->assigned_user->first_name ?? ''}}  {{$list->assigned_user->last_name ?? ''}}</td>
											<td>{{ $user_name??'N/P' }}</td>
                                            <td><a href="{{URL::to('/admin/clients/detail/'.base64_encode(convert_uuencode(@$list->client_id)))}}" target="_blank" >{{ $list->noteClient->client_id ?? 'N/P' }}</a></td>
											<td>{{ date('d/m/Y',strtotime($list->followup_date)) ?? 'N/P'}} </td>
                                            <td>{{ $list->task_group??'N/P' }}</td>
                                            <td>{{ $list->description??'N/P' }}</td>

                                            <!--
											<td>{{-- $list->title??'N/P' --}}</td>
											<td>{{-- $list->noteClient->service??'N/P' --}}</td>-->

											<!--@if($list->noteClient->status === 0)
											<td><span title="draft" class="ui label uppercase badge bg-warning">Pending</span></td>
											@elseif($list->noteClient->status === 1)
											<td><span title="draft" class="ui label uppercase badge bg-success">Approved</span></td>
											@elseif($list->noteClient->status === 'Unassigned')
											<td><span title="draft" class="ui label uppercase badge bg-warning">Unassigned</span></td>
											@elseif($list->noteClient->status === 'Assigned')
											<td><span title="draft" class="ui label uppercase badge bg-info">Assigned</span></td>
											@elseif($list->noteClient->status === 'In-Progress')

											<td><span title="draft" class="ui label uppercase badge bg-primary">In-Progress</span></td>
											@elseif($list->noteClient->status === 'Closed')
											<td><span title="draft" class="ui label uppercase badge bg-success">Closed</span></td>
											@else
											<td><span title="draft" class="ui label uppercase badge bg-warning">Pending</span></td>
											@endif-->


											<td>
												@if($list->noteClient)
												<form action="{{ route('assignee.destroy',$list->id) }}" method="POST">

													{{-- <a class="btn btn-info" href="{{ route('assignees.show',$list->id) }}">Show</a> --}}

													{{--<a class="btn btn-primary" href="{{ url('/admin/clients/edit/'.base64_encode(convert_uuencode(@$list->client_id)).'') }}">Edit</a>--}}
                                                    <a class="btn btn-primary complete_task" data-id="{{ $list->id }}" href="javascript:void(0)">Complete</a>

													@csrf
													@method('DELETE')

													<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?');">Delete</button>
													<button type="button" class="btn btn-primary btn-block" data-container="body" data-role="popover" data-placement="bottom" data-html="true" data-content="<div id=&quot;popover-content&quot;>
														<h4 class=&quot;text-center&quot;>Re-Assign User</h4>
														<div class=&quot;clearfix&quot;></div>
													<div class=&quot;box-header with-border&quot;>
														<div class=&quot;form-group row&quot; style=&quot;margin-bottom:12px&quot; >
															<label for=&quot;inputSub3&quot; class=&quot;col-sm-3 control-label c6 f13&quot; style=&quot;margin-top:8px&quot;>Select Assignee</label>
															<div class=&quot;col-sm-9&quot;>
																<select class=&quot;assigneeselect2 form-control selec_reg&quot; id=&quot;rem_cat&quot; name=&quot;rem_cat&quot; onchange=&quot;&quot;>
																	<option value=&quot;&quot; >Select</option>
																	@foreach(\App\Admin::where('role','!=',7)->orderby('first_name','ASC')->get() as $admin)
																	<?php
																	$branchname = \App\Branch::where('id',$admin->office_id)->first();
																	?>
																	<option value=&quot;<?php echo $admin->id; ?>&quot;><?php echo $admin->first_name.' '.$admin->last_name.' ('.@$branchname->office_name.')'; ?></option>
																	@endforeach
																</select>
															</div>
															<div class=&quot;clearfix&quot;></div>
														</div>
													</div><div id=&quot;popover-content&quot;>
													<div class=&quot;box-header with-border&quot;>
														<div class=&quot;form-group row&quot; style=&quot;margin-bottom:12px&quot; >
															<label for=&quot;inputEmail3&quot; class=&quot;col-sm-3 control-label c6 f13&quot; style=&quot;margin-top:8px&quot;>Note</label>
															<div class=&quot;col-sm-9&quot;>
																<textarea id=&quot;assignnote&quot; class=&quot;form-control summernote-simple f13&quot; placeholder=&quot;Enter an note....&quot; type=&quot;text&quot;></textarea>
															</div>
															<div class=&quot;clearfix&quot;></div>
														</div>
													</div>
													<div class=&quot;box-header with-border&quot;>
														<div class=&quot;form-group row&quot; style=&quot;margin-bottom:12px&quot; >
															<label for=&quot;inputEmail3&quot; class=&quot;col-sm-3 control-label c6 f13&quot; style=&quot;margin-top:8px&quot;>Date</label>
															<div class=&quot;col-sm-9&quot;>
																<input type=&quot;datetime-local&quot; class=&quot;form-control f13&quot; placeholder=&quot;yyyy-mm-dd,h:i:s&quot; id=&quot;popoverdatetime&quot; value=&quot;<?php echo date('Y-m-d h:i:s');?>&quot;name=&quot;popoverdate&quot;>
															</div>
															<div class=&quot;clearfix&quot;></div>
														</div>
													</div>

                                                    <div class=&quot;form-group row&quot; style=&quot;margin-bottom:12px&quot; >
                                                        <label for=&quot;inputSub3&quot; class=&quot;col-sm-3 control-label c6 f13&quot; style=&quot;margin-top:8px&quot;>Group</label>
                                                        <div class=&quot;col-sm-9&quot;>
                                                            <select class=&quot;assigneeselect2 form-control selec_reg&quot; id=&quot;task_group&quot; name=&quot;task_group&quot;>
                                                                <option value=&quot;&quot;>Select</option>
                                                                <option value=&quot;Call&quot;>Call</option>
                                                                <option value=&quot;Checklist&quot;>Checklist</option>
                                                                <option value=&quot;Review&quot;>Review</option>
                                                                <option value=&quot;Query&quot;>Query</option>
                                                                <option value=&quot;Urgent&quot;>Urgent</option>
                                                            </select>
                                                        </div>
                                                        <div class=&quot;clearfix&quot;></div>
                                                    </div>

													<input id=&quot;assign_client_id&quot;  type=&quot;hidden&quot; value=&quot;{{base64_encode(convert_uuencode(@$list->client_id))}}&quot;>
													<div class=&quot;box-footer&quot; style=&quot;padding:10px 0&quot;>
													<div class=&quot;row&quot;>
														<input type=&quot;hidden&quot; value=&quot;&quot; id=&quot;popoverrealdate&quot; name=&quot;popoverrealdate&quot; />
													</div>
													<div class=&quot;row text-center&quot;>
														<div class=&quot;col-md-12 text-center&quot;>
														<button  class=&quot;btn btn-info&quot; id=&quot;assignUser&quot;>Assign User</button>
														</div>
													</div>
											</div>" data-original-title="" title="" style="width: 85px;display: inline;">Reassign</button>
									{{-- <a class="btn btn-primary openassigneview" id="{{$list->id}}" href="#">Reassign</a> --}}
												</form>
												@endif
											</td>


										</tr>
										@endforeach
									</table>
										{{-- {!! $assignees->appends(\Request::except('page'))->render() !!} --}}
   										 {!! $assignees->appends($_GET)->links() !!}
								</div>
								<div class="card-footer">

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
		<div class="modal-content taskview">

		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{URL::to('/')}}/js/popover.js"></script>
<script>
	jQuery(document).ready(function($){
     $(document).delegate('.openassignee', 'click', function(){
        $('.assignee').show();
    });
	$(document).delegate('.closeassignee', 'click', function(){
        $('.assignee').hide();
    });

    //Function is used for complete the task
	$(document).delegate('.complete_task', 'click', function(){
		var row_id = $(this).attr('data-id');
        if(row_id !=""){ //&& confirm('Are you sure want to complete the task?')
            $.ajax({
				type:'post',
                url:"{{URL::to('/')}}/admin/update-task-completed",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id:row_id },
                success: function(response){
                    //console.log(response);
                    var obj = $.parseJSON(response);
                    location.reload();
                }
			});
        }
	});

    $(document).delegate('#assignUser','click', function(){
		$(".popuploader").show();
		var flag = true;
		var error ="";
		$(".custom-error").remove();
		// if($('#lead_id').val() == ''){
		// 	$('.popuploader').hide();
		// 	error="Lead field is required.";
		// 	$('#lead_id').after("<span class='custom-error' role='alert'>"+error+"</span>");
		// 	flag = false;
		// }
		if($('#rem_cat').val() == ''){
			$('.popuploader').hide();
			error="Assignee field is required.";
			$('#rem_cat').after("<span class='custom-error' role='alert'>"+error+"</span>");
			flag = false;
		}
		if($('#assignnote').val() == ''){
			$('.popuploader').hide();
			error="Note field is required.";
			$('#assignnote').after("<span class='custom-error' role='alert'>"+error+"</span>");
			flag = false;
		}
        if($('#task_group').val() == ''){
			$('.popuploader').hide();
			error="Group field is required.";
			$('#task_group').after("<span class='custom-error' role='alert'>"+error+"</span>");
			flag = false;
		}
		if(flag){
			$.ajax({
				type:'post',
					url:"{{URL::to('/')}}/admin/clients/followup/store",
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

					data: {note_type:'follow_up',description:$('#assignnote').val(),client_id:$('#assign_client_id').val(),followup_datetime:$('#popoverdatetime').val(),assignee_name:$('#rem_cat :selected').text(),rem_cat:$('#rem_cat option:selected').val(),task_group:$('#task_group option:selected').val()},
					success: function(response){
						console.log(response);
						$('.popuploader').hide();
						var obj = $.parseJSON(response);
						if(obj.success){
							$("[data-role=popover]").each(function(){
									(($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
							});
							location.reload();
							getallactivities();
							getallnotes();

						}else{
							alert(obj.message);
							location.reload();

						}
					}
			});
		}else{
			$("#loader").hide();
		}
	});

	$(document).delegate('.saveassignee', 'click', function(){
        var appliid = $(this).attr('data-id');

		var assinee= $('#changeassignee').val();
		$('.popuploader').show();
		// console.log($('#changeassignee').val());
		$.ajax({
			url: site_url+'/admin/change_assignee',
			type:'GET',
			data:{id: appliid,assinee: assinee},
			success: function(response){
				// console.log(response);
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

	$(document).delegate('.savecomment', 'click', function(){
		var visitcomment = $('.taskcomment').val();
		var appliid = $(this).attr('data-id');
		$('.popuploader').show();
		$.ajax({
			url: site_url+'/admin/update_apppointment_comment',
			type:'POST',
			data:{"_token":$('meta[name="csrf-token"]').attr('content'),id: appliid,visit_comment:visitcomment},
			success: function(responses){
				// $('.popuploader').hide();
				$('.taskcomment').val('');
				$.ajax({
					url: site_url+'/admin/get-assigne-detail',
					type:'GET',
					data:{id:appliid},
					success: function(responses){
						$('.popuploader').hide();
						$('.taskview').html(responses);
					}
				});
			}
		});
	});
	$(document).delegate('.openassigneview', 'click', function(){
	// $('.popuploader').hide();
	$('#openassigneview').modal('show');
	var v = $(this).attr('id');
		$.ajax({
			url: site_url+'/admin/get-assigne-detail',
			type:'GET',
			data:{id:v},
			success: function(responses){
				$('.popuploader').hide();
				$('.taskview').html(responses);
			}
		});
	});

	$(document).delegate('.changestatus', 'click', function(){
		var appliid = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		var statusame = $(this).attr('data-status-name');
		$('.popuploader').show();

		$.ajax({
			url: site_url+'/admin/update_list_status',
			type:'POST',
			data:{"_token":$('meta[name="csrf-token"]').attr('content'),id: appliid,statusname:statusame,status:status},
			success: function(responses){
				$('.popuploader').hide();
				var obj = JSON.parse(responses);
				if(obj.status){
				    console.log(obj.status);
				    $('.updatestatusview'+appliid).html(obj.viewstatus);
				}
				$.ajax({
					url: site_url+'/admin/get-assigne-detail',
					type:'GET',
					data:{id:appliid},
					success: function(responses){
						$('.popuploader').hide();
						$('.taskview').html(responses);
					}
				});
			}
		});
	});


	$(document).delegate('.changepriority', 'click', function(){
		var appliid = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		$('.popuploader').show();

		$.ajax({
			url: site_url+'/admin/update_list_priority',
			type:'POST',
			data:{"_token":$('meta[name="csrf-token"]').attr('content'),id: appliid,status:status},
			success: function(responses){
				$('.popuploader').hide();

				$.ajax({
					url: site_url+'/admin/get-assigne-detail',
					type:'GET',
					data:{id:appliid},
					success: function(responses){
						$('.popuploader').hide();
						console.log(responses);
						$('.taskview').html(responses);

					}
				});
			}
		});
	});

	$(document).delegate('.desc_click', 'click', function(){
		$(this).hide();
		$('.taskdesc').show();
		$('.taskdesc').focus();
	});
	$(document).delegate('.taskdesc', 'blur', function(){
		$(this).hide();
		$('.desc_click').show();
	});

	$(document).delegate('.tasknewdesc', 'blur', function(){
		var visitpurpose = $(this).val();
		var appliid = $(this).attr('data-id');
		$('.popuploader').show();
		$.ajax({
			url: site_url+'/admin/update_apppointment_description',
			type:'POST',
			data:{"_token":$('meta[name="csrf-token"]').attr('content'),id: appliid,visit_purpose:visitpurpose},
			success: function(responses){
				$.ajax({
					url: site_url+'/admin/get-assigne-detail',
					type:'GET',
					data:{id:appliid},
					success: function(responses){
						$('.popuploader').hide();
						$('.taskview').html(responses);
					}
				});

			}
		});
	});

	$(document).delegate('.taskdesc', 'blur', function(){
		var visitpurpose = $(this).val();
		var appliid = $(this).attr('data-id');
		$('.popuploader').show();
		$.ajax({
			url: site_url+'/admin/update_apppointment_description',
			type:'POST',
			data:{"_token":$('meta[name="csrf-token"]').attr('content'),id: appliid,visit_purpose:visitpurpose},
			success: function(responses){
				 $.ajax({
					url: site_url+'/admin/get-assigne-detail',
					type:'GET',
					data:{id:appliid},
					success: function(responses){
						$('.popuploader').hide();
						$('.taskview').html(responses);
					}
				});

			}
		});
	});
});
</script>
@endsection
