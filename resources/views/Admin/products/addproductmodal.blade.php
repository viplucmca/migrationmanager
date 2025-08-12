<!-- Appliation Modal -->
<div class="modal fade add_appliation custom_modal" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content"> 
			<div class="modal-header">
				<h5 class="modal-title" id="appliationModalLabel">Add Appliation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/saveapplication')}}" name="applicationform" id="addapplicationformform" autocomplete="off" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="workflow">Select Workflow <span class="span_req">*</span></label>
								<select data-valid="required" class="form-control workflow select2" id="workflow" name="workflow">
									<option value="">Please Select a Workflow</option>
									@foreach(\App\Workflow::all() as $wlist)
										<option value="{{$wlist->id}}">{{$wlist->name}}</option>
									@endforeach
								</select>
								<span class="custom-error workflow_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="partner_branch">Select Partner & Branch <span class="span_req">*</span></label> 
								<select data-valid="required" class="form-control partner_branch select2" id="partner" name="partner_branch">
									<option value="">Please Select a Partner & Branch</option>
								</select> 
								<span class="custom-error partner_branch_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="product">Select Product</label> 
								<select data-valid="required" class="form-control product select2" id="product" name="product">
									<option value="">Please Select a Product</option>
									
								</select> 
								<span class="custom-error product_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('applicationform')" type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

<!-- Interested Service Modal -->
<div class="modal fade add_interested_service custom_modal" tabindex="-1" role="dialog" aria-labelledby="create_interestModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="interestModalLabel">Add Interested Services</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/interested-service')}}" name="inter_servform" autocomplete="off" id="inter_servform" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="intrested_workflow">Select Workflow <span class="span_req">*</span></label>
								<select data-valid="required" class="form-control select2" id="intrested_workflow" name="workflow">
									<option value="">Please Select a Workflow</option>
									@foreach(\App\Workflow::all() as $wlist)
										<option value="{{$wlist->id}}">{{$wlist->name}}</option>
									@endforeach
								</select>
								<span class="custom-error workflow_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="intrested_partner">Select Partner</label> 
								<select data-valid="required" class="form-control select2" id="intrested_partner" name="partner">
									<option value="">Please Select a Partner</option>
									
								</select> 
								<span class="custom-error partner_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="intrested_product">Select Product</label> 
								<select data-valid="required" class="form-control select2" id="intrested_product" name="product">
									<option value="">Please Select a Product</option>
									
								</select> 
								<span class="custom-error product_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="branch">Select Branch</label> 
								<select data-valid="required" class="form-control select2" id="intrested_branch" name="branch">
									<option value="">Please Select a Branch</option>
									
								</select> 
								<span class="custom-error branch_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group"> 
								<label for="expect_start_date">Expected Start Date</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-calendar-alt"></i>
										</div>
									</div>
									{{ Form::text('expect_start_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
								</div>
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
								<span class="custom-error expect_start_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group"> 
								<label for="expect_win_date">Expected Win Date</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-calendar-alt"></i>
										</div>
									</div>
									{{ Form::text('expect_win_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
								</div> 
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
								<span class="custom-error expect_win_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('inter_servform')" type="button" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>  
			</div>
		</div>
	</div>
</div>

<!-- Appointment Modal -->
<div class="modal fade add_appointment custom_modal" id="create_appoint" tabindex="-1" role="dialog" aria-labelledby="create_interestModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="interestModalLabel">Add Appointment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/add-appointment')}}" name="appointform" id="appointform" autocomplete="off" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
						<?php
						$timelist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
						?>
							<div class="form-group">
								<label style="display:block;" for="related_to">Related to:</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="client" value="Client" name="related_to" checked>
									<label class="form-check-label" for="client">Client</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="partner" value="Partner" name="related_to">
									<label class="form-check-label" for="partner">Partner</label>
								</div>
								<span class="custom-error related_to_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label style="display:block;" for="related_to">Added by:</label>
								<span>{{@Auth::user()->first_name}}</span>
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="client_name">Client Name <span class="span_req">*</span></label>
								{{ Form::text('client_name', @$fetchedData->first_name.' '.@$fetchedData->last_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Client Name','readonly'=>'readonly' )) }} 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="timezone">Timezone <span class="span_req">*</span></label>
								<select class="form-control timezoneselect2" name="timezone" data-valid="required">
									<option value="">Select Timezone</option>
									<?php
									foreach($timelist as $tlist){
										?>
										<option value="<?php echo $tlist; ?>" <?php if($tlist == 'Australia/Melbourne'){ echo "selected"; } ?>><?php echo $tlist; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-12 col-md-7 col-lg-7">
							<div class="form-group"> 
								<label for="appoint_date">Date</label>
								<div class="input-group">
									<div class="input-group-prepend"> 
										<div class="input-group-text">
											<i class="fas fa-calendar-alt"></i>
										</div>
									</div>
									{{ Form::text('appoint_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
								</div>
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
								<span class="custom-error appoint_date_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-5 col-lg-5">
							<div class="form-group"> 
								<label for="appoint_time">Time</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-clock"></i>
										</div>
									</div>
									{{ Form::text('appoint_time', '', array('class' => 'form-control timepicker', 'data-valid'=>'required', 'autocomplete'=>'off',  'placeholder'=>'Select Time', 'readonly')) }}
								</div>
								<span class="custom-error appoint_time_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="title">Title <span class="span_req">*</span></label>
								{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Title' )) }} 
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="description">Description</label>
								<textarea class="form-control" name="description" placeholder="Description"></textarea>
								<span class="custom-error description_error" role="alert">
									<strong></strong>
								</span> 
							</div>	
						</div>	
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="invitees">Invitees</label>
								<select class="form-control select2" name="invitees">
									<option>Select Invitees</option>
									
								</select>
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('appointform')" type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>  
			</div>
		</div>
	</div>
</div>
 
<!-- Note & Terms Modal -->
<div class="modal fade custom_modal" id="create_note" tabindex="-1" role="dialog" aria-labelledby="create_noteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="appliationModalLabel">Create Note</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/create-note')}}" name="notetermform" autocomplete="off" id="notetermform" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
				<input type="hidden" name="noteid" value="">
				<input type="hidden" name="mailid" value="0">
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="title">Title <span class="span_req">*</span></label>
								{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Title' )) }}
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="description">Description <span class="span_req">*</span></label>
								<textarea class="summernote-simple" name="description" data-valid="required"></textarea>
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<!--<div class="col-12 col-md-12 col-lg-12 is_not_note" style="display:none;">
							<div class="form-group"> 
								<label class="d-block" for="">Related To</label> 
								<div class="form-check form-check-inline">
									<input class="" type="radio" id="note_contact" value="Contact" name="related_to_note" checked>
									<label style="padding-left: 6px;" class="form-check-label" for="note_contact">Contact</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="" type="radio" id="note_partner" value="Partner" name="related_to_note">
									<label style="padding-left: 6px;" class="form-check-label" for="note_partner">Partner</label>
								</div> 
								<div class="form-check form-check-inline">
									<input class="" type="radio" id="note_application" value="Application" name="related_to_note">
									<label style="padding-left: 6px;" class="form-check-label" for="note_application">Application</label>
								</div>
							
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12 is_not_note" style="display:none;">
							<div class="form-group">
								<label for="contact_name">Contact Name <span class="span_req">*</span></label> 	
								<select data-valid="" class="form-control contact_name js-data-example-ajaxcc" name="contact_name[]">
									
									
								</select>
								<span class="custom-error contact_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>-->
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('notetermform')" type="button" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

<!-- Task Modal -->
<div class="modal fade custom_modal" id="opentaskview" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content taskview">
			
		</div>
	</div>
</div>
<div class="modal fade create_task custom_modal" id="opentaskmodal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="taskModalLabel">Create New Task</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/tasks/store/')}}" name="taskform" autocomplete="off" id="tasktermform" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="mailid" value="">
				
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="title">Title <span class="span_req">*</span></label>
								{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Title' )) }}
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="category">Category <span class="span_req">*</span></label> 
								<select data-valid="required" class="form-control category select2" name="category">
									<option value="">Choose Category</option>
									<option value="Reminder">Reminder</option>
									<option value="Call">Call</option>
									<option value="Follow Up">Follow Up</option>
									<option value="Email">Email</option>
									<option value="Meeting">Meeting</option>
									<option value="Support">Support</option>
									<option value="Others">Others</option>
								</select> 
								<span class="custom-error category_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="assignee">Assignee</label> 
								<select data-valid="" class="form-control assignee select2" name="assignee">
									<option value="">Select</option>
									<?php
									$headoffice = \App\Admin::where('role',1)->get();
									foreach($headoffice as $holist){
										?>
										<option value="{{$holist->id}}">{{$holist->first_name}} ({{$holist->primary_email}})</option>
										<?php
									}
									?>
								</select> 
								<span class="custom-error assignee_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="priority">Priority</label> 
								<select data-valid="" class="form-control priority select2" name="priority">
									<option value="">Choose Priority</option>
									<option value="Low">Low</option>
									<option value="Normal">Normal</option>
									<option value="High">High</option>
									<option value="Urgent">Urgent</option>
								</select> 
								<span class="custom-error priority_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-4 col-lg-4">
							<div class="form-group">
								<label for="due_date">Due Date</label> 
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-calendar-alt"></i>
										</div>
									</div>	
									{{ Form::text('due_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
								</div>
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
								<span class="custom-error due_date_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-4 col-lg-4">
							<div class="form-group">
								<label for="due_time">Due Time</label> 
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-clock"></i>
										</div> 
									</div>	
									{{ Form::text('due_time', '', array('class' => 'form-control timepicker', 'data-valid'=>'', 'autocomplete'=>'off', 'placeholder'=>'Select Time', 'readonly' )) }} 
								</div> 
								<span class="custom-error due_time_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="description">Description</label> 
								<textarea class="form-control" name="description"></textarea>
								<span class="custom-error description_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12 ifselecttask">
							<div class="form-group"> 
								<label class="d-block" for="related_to">Related To</label> 
								<div class="form-check form-check-inline">
									<input  type="radio" id="contact" value="Contact" name="related_to" checked>
									<label style="padding-left:6" class="form-check-label" for="contact">Contact</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="" type="radio" id="partner" value="Partner" name="related_to">
									<label style="padding-left:6" class="form-check-label" for="partner">Partner</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="" type="radio" id="application" value="Application" name="related_to">
									<label style="padding-left:6" class="form-check-label" for="application">Application</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="" type="radio" id="internal" value="Internal" name="related_to">
									<label style="padding-left:6" class="form-check-label" for="internal">Internal</label>
								</div>
								@if ($errors->has('related_to'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('related_to') }}</strong>
									</span> 
								@endif
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 is_contact ifselecttask">
							<div class="form-group">
								<label for="contact_name">Contact Name <span class="span_req">*</span></label> 	
								<select data-valid="required" class="form-control contact_name js-data-example-ajaxcontact" name="contact_name[]">
								
								</select>
								<span class="custom-error contact_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 is_partner ifselecttask">
							<div class="form-group">
								<label for="partner_name">Partner Name <span class="span_req">*</span></label> 	
								<select data-valid="" class="form-control partner_name select2" name="partner_name">
									<option value="">Choose Partner</option>
									<option value="Amit">Amit</option>
								</select>
								<span class="custom-error partner_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 is_application ifselecttask">
							<div class="form-group">
								<label for="client_name">Client Name <span class="span_req">*</span></label> 	
								<select data-valid="" class="form-control client_name select2" name="client_name">
									<option value="">Choose Client</option>
									<option value="Amit">Amit</option>
								</select>
								<span class="custom-error client_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 is_application ifselecttask">
							<div class="form-group">
								<label for="application">Application <span class="span_req">*</span></label> 	
								<select data-valid="" class="form-control application select2" name="application">
									<option value="">Choose Application</option>
									<option value="Demo">Demo</option>
								</select>
								<span class="custom-error application_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 is_application ifselecttask">
							<div class="form-group">
								<label for="stage">Stage <span class="span_req">*</span></label> 	
								<select data-valid="" class="form-control stage select2" name="stage">
									<option value="">Choose Stage</option>
									<option value="Stage 1">Stage 1</option>
								</select>
								<span class="custom-error stage_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="followers">Followers <span class="span_req">*</span></label> 	
								<select data-valid="" multiple class="form-control followers  select2" name="followers">
									<option value="">Choose Followers</option>
									<?php foreach($headoffice as $holist){
										?>
										<option value="{{$holist->id}}">{{$holist->first_name}} ({{$holist->primary_email}})</option>
										<?php
									}
									?>
								</select>
								<span class="custom-error followers_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="attachments">Attachments</label> 	
								<div class="custom-file">
									<input type="file" name="attachments" class="custom-file-input" id="attachments">
									<label class="custom-file-label showattachment" for="attachments">Choose file</label>
								</div>
								<span class="custom-error attachments_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
						<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
							<button onclick="customValidate('taskform')" type="button" class="btn btn-primary">Create</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

<!-- Education Modal -->
<div class="modal fade custom_modal" id="add_academic_requirement" tabindex="-1" role="dialog" aria-labelledby="academiModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="academiModalLabel">Add Academic Requirements</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/saveacademic')}}" name="saveacademic" id="saveacademic" autocomplete="off" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
				
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="degree_level">Degree Level <span class="span_req">*</span></label> 	
								<select data-valid="required" class="form-control degree_level select2" name="degree_level">
									<option value="">Please Select Degree Level</option>
									<option value="Bachelor">Bachelor</option>
									<option value="Certificate">Certificate</option>
									<option value="Diploma">Diploma</option>
									<option value="High School">High School</option>
									<option value="Master">Master</option>
								</select>
								<span class="custom-error degree_level_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group"> 
								<label class="d-block" for="academic_score">Academic Score</label> 
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="percentage" value="%" name="academic_score_type" checked>
									<label class="form-check-label" for="percentage">Percentage</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="GPA" value="GPA" name="academic_score_type">
									<label class="form-check-label" for="GPA">GPA</label>
								</div>
								{{ Form::number('academic_score', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','step'=>'0.01' )) }}
								<span class="custom-error academic_score_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div> 
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('saveacademic')" type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div> 

<!-- Education Modal -->
<div class="modal fade custom_modal" id="other_info_add" tabindex="-1" role="dialog" aria-labelledby="academiModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="academiModalLabel">Add Subject Area & Level</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form method="post" action="{{URL::to('/admin/saveotherinfo')}}" name="savesubjectarea" id="savesubjectarea" autocomplete="off" enctype="multipart/form-data">
			@csrf 
			<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
			
				<div class="row">
					<div class="col-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="degree_level">Subject Area <span class="span_req">*</span></label> 	
							<select data-valid="" class="form-control subject_area select2" id="subjectlist" name="subject_area">
									<option value="">Please Select Subject Area</option>
									<?php
									foreach(\App\SubjectArea::all() as $sublist){
										?>
										<option value="{{$sublist->id}}">{{$sublist->name}}</option>
										<?php
									}
									?>
								</select>
							<span class="custom-error degree_level_error" role="alert">
								<strong></strong>
							</span> 
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="degree_level">Subject<span class="span_req">*</span></label> 	
							<select data-valid="" class="form-control subject select2" id="subject" name="subject">
									<option value="">Please Select Subject</option>
								</select>
							<span class="custom-error degree_level_error" role="alert">
								<strong></strong>
							</span> 
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="degree_level">Degree Level</label> 	
							<select data-valid="required" class="form-control degree_level select2" name="degree_level">
								<option value=""></option>
								<option value="Bachelor">Bachelor</option>
									<option value="Certificate">Certificate</option>
									<option value="Diploma">Diploma</option>
									<option value="High School">High School</option>
									<option value="Master">Master</option>
							</select>
							<span class="custom-error degree_level_error" role="alert">
								<strong></strong>
							</span> 
						</div>
					</div>
					<div class="col-12 col-md-12 col-lg-12">
						<button onclick="customValidate('savesubjectarea')" type="button" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form> 
		</div>
	</div>
</div>
</div> 

<div class="modal fade custom_modal" id="other_info_edit" tabindex="-1" role="dialog" aria-labelledby="academiModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="academiModalLabel">Edit Subject Area & Level</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form method="post" action="{{URL::to('/admin/saveotherinfo')}}" name="editsubjectarea" id="editsubjectarea" autocomplete="off" enctype="multipart/form-data">
			@csrf 
			<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
			
				<div class="row showsubjecthtml">
					
				</div>
			</form> 
		</div>
	</div>
</div>
</div> 

<!-- Note & Terms Modal -->
<div class="modal fade custom_modal" id="opencommissionmodal" tabindex="-1" role="dialog" aria-labelledby="create_noteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="appliationModalLabel">Commission Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/create-invoice')}}" name="noteinvform" autocomplete="off" id="noteinvform" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
			
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
						<?php
						$timelist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
						?>
							<div class="form-group">
								<label style="display:block;" for="invoice_type">Choose invoice:</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="net_invoice" value="1" name="invoice_type" checked>
									<label class="form-check-label" for="net_invoice">Net Claim Invoice</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="gross_invoice" value="2" name="invoice_type">
									<label class="form-check-label" for="gross_invoice">Gross Claim Invoice</label>
								</div>
								<span class="custom-error related_to_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="client">Client <span class="span_req">*</span></label>
								{{ Form::text('client', @$fetchedData->first_name.' '.@$fetchedData->last_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="description">Application <span class="span_req">*</span></label>
								<select data-valid="required" class="form-control select2" name="application">
									<option value="">Select</option>
									@foreach(\App\Application::where('client_id',$fetchedData->id)->get() as $aplist)
									<?php
									$productdetail = \App\Product::where('id', $aplist->product_id)->first();
				$partnerdetail = \App\Partner::where('id', $aplist->partner_id)->first();
				$PartnerBranch = \App\PartnerBranch::where('id', $aplist->branch)->first();
				$workflow = \App\Workflow::where('id', $aplist->workflow)->first();
									?>
										<option value="{{$aplist->id}}">{{$productdetail->name}} ({{$partnerdetail->partner_name}})</option>
									@endforeach
								</select>
								
							</div>
						</div>
					
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('noteinvform')" type="button" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>  
			</div>
		</div>
	</div>
</div>

<!-- Note & Terms Modal -->
<div class="modal fade custom_modal" id="opengeneralinvoice" tabindex="-1" role="dialog" aria-labelledby="create_noteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="appliationModalLabel">General Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/create-invoice')}}" name="notegetinvform" autocomplete="off" id="notegetinvform" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
			
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
						<?php
						$timelist = \DateTimeZone::listIdentifiers(DateTimeZone::ALL);
						?>
							<div class="form-group">
								<label style="display:block;" for="invoice_type">Choose invoice:</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" id="net_invoice" value="3" name="invoice_type" checked>
									<label class="form-check-label" for="net_invoice">Client Invoice</label>
								</div> 
								
								<span class="custom-error related_to_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="client">Client <span class="span_req">*</span></label>
								{{ Form::text('client', @$fetchedData->first_name.' '.@$fetchedData->last_name, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'' )) }}
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="description">Service <span class="span_req">*</span></label>
								<select data-valid="required" class="form-control select2" name="application">
									<option value="">Select</option>
									@foreach(\App\Application::where('client_id',$fetchedData->id)->groupby('workflow')->get() as $aplist)
									<?php
									
				$workflow = \App\Workflow::where('id', $aplist->workflow)->first();
									?>
										<option value="{{$workflow->id}}">{{$workflow->name}}</option>
									@endforeach
								</select>
								
							</div>
						</div>
					
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('notegetinvform')" type="button" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

<div id="addpaymentmodal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="false" class="modal fade" >
	<div class="modal-dialog">
	{{ Form::open(array('url' => 'admin/invoice/payment-store', 'name'=>"ajaxinvoicepaymentform", 'autocomplete'=>'off', "enctype"=>"multipart/form-data", "id"=>"ajaxinvoicepaymentform")) }}
	<input type="hidden" value="" name="invoice_id" id="invoice_id">
	<input type="hidden" value="true" name="is_ajax" id="">
	<input type="hidden" value="{{$fetchedData->id}}" name="client_id" id="">
		<div class="modal-content ">
			<div class="modal-header">
				<h4 class="modal-title">Payment Details</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
			
				<div class="payment_field">
					<div class="payment_field_row">
						<div class="payment_field_col payment_first_step">
							<div class="field_col">
								<div class="label_input">
									<input data-valid="required" type="number" name="payment_amount[]" placeholder="" class="paymentAmount" />
									<div class="basic_label">AUD</div>
								</div>
							</div>
							
							<div class="field_col">
								<select name="payment_mode[]" class="form-control">
									<option value="Cheque">Cheque</option>
									<option value="Cash">Cash</option>
									<option value="Credit Card">Credit Card</option>
									<option value="Bank Transfers">Bank Transfers</option>
								</select>
							</div>
							<div class="field_col">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-clock"></i>
										</div>
									</div>	
									<input type="text" name="payment_date[]" placeholder="" class="datepicker form-control" />
								</div>
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
							</div>
							<div class="field_remove_col">
								<a href="javascript:;" class="remove_col"><i class="fa fa-times"></i></a>
							</div>
						</div>
					</div>
					<div class="add_payment_field">
						<a href="javascript:;"><i class="fa fa-plus"></i> Add New Line</a>
					</div>
					<div class="clearfix"></div>
					<div class="invoiceamount">
						<table class="table">
							<tr>
								<td><b>Invoice Amount:</b></td>
								<td class="invoicenetamount"></td>
								<td><b>Total Due:</b></td>
								<td class="totldueamount" data-totaldue=""></td>
							</tr>
						
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="customValidate('ajaxinvoicepaymentform')" class="btn btn-primary" >Save & Close</button>
				<button type="button" class="btn btn-primary">Save & Send Receipt</button>
			  </div>
		</div>
		</form>
	</div>
</div>

<div class="modal fade custom_modal" id="create_applicationnote" tabindex="-1" role="dialog" aria-labelledby="create_noteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="appliationModalLabel">Create Note</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/create-app-note')}}" name="appnotetermform" autocomplete="off" id="appnotetermform" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
				<input type="hidden" name="noteid" id="noteid" value="">
				<input type="hidden" name="type" id="type" value="">
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="title">Title <span class="span_req">*</span></label>
								{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Title' )) }}
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="description">Description <span class="span_req">*</span></label>
								<textarea class="summernote-simple" name="description" data-valid="required"></textarea>
								<span class="custom-error title_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('appnotetermform')" type="button" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

<!-- Checklist Modal -->
<div class="modal fade custom_modal" id="create_checklist" tabindex="-1" role="dialog" aria-labelledby="create_checklistModalLabel" aria-hidden="true">
	<div class="modal-dialog"> 
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="checklistModalLabel">Add New Checklist</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/add-appointment')}}" name="checklistform" id="checklistform" autocomplete="off" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
					<div class="row">						
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="document_type">Document Type <span class="span_req">*</span></label>
								<select class="form-control select2" name="document_type" data-valid="required">
									<option value="">Please Select Document Type</option>
									<option value="Salary Statement">Salary Statement</option>
									<option value="Experience Letter">Experience Letter</option>
									<option value="Transcripts">Transcripts</option>
									<option value="Academic Certificates">Academic Certificates</option>
									<option value="Passport">Passport</option>
									<option value="Citizenship">Citizenship</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="description">Description</label>
								<textarea class="form-control" name="description" placeholder="Description"></textarea>
								<span class="custom-error description_error" role="alert">
									<strong></strong>
								</span> 
							</div>	
						</div>	
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" value="Allow clients to upload documents from client portal" name="allow_upload_docu">
									<label class="form-check-label" for="allow_upload_docu">Allow clients to upload documents from client portal</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" value="Make this as mandatory inorder to proceed next stage" name="proceed_next_stage">
									<label class="form-check-label" for="proceed_next_stage">Make this as mandatory inorder to proceed next stage</label>
								</div> 
							</div>
						</div>	
					</div>	
					<div class="due_date_sec">
						<a href="javascript:;" class="btn btn-primary due_date_btn"><i class="fa fa-plus"></i> Add Due Date</a>
						<div class="due_date_col">	  
							<div class="row">	 
								<div class="col-12 col-md-6 col-lg-6">
									<div class="form-group"> 
										<label for="appoint_date">Date</label>
										<div class="input-group">
											<div class="input-group-prepend"> 
												<div class="input-group-text">
													<i class="fas fa-calendar-alt"></i>
												</div>
											</div>
											{{ Form::text('appoint_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
										</div>
										<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
										<span class="custom-error appoint_date_error" role="alert">
											<strong></strong>
										</span> 
									</div>
								</div>
								<div class="col-12 col-md-5 col-lg-5">
									<div class="form-group"> 
										<label for="appoint_time">Time</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fas fa-clock"></i>
												</div>
											</div>
											{{ Form::text('appoint_time', '', array('class' => 'form-control timepicker', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Select Time' )) }}
										</div>
										<span class="custom-error appoint_time_error" role="alert">
											<strong></strong>
										</span> 
									</div>
								</div>
								<div class="col-12 col-md-1 col-lg-1 remove_col">
									<a href="javascript:;" class="remove_btn"><i class="fa fa-trash"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('checklistform')" type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>  
			</div>
		</div>
	</div>
</div>

<!-- Payment Schedule Modal -->
<div class="modal fade custom_modal paymentschedule" id="create_paymentschedule" tabindex="-1" role="dialog" aria-labelledby="create_paymentscheduleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">  
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="paymentscheduleModalLabel">Add Payment Schedule</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/add-appointment')}}" name="paymentform" id="paymentform" autocomplete="off" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="client_name">Client Name</label>
								{{ Form::text('client_name', '', array('class' => 'form-control', 'autocomplete'=>'off', 'data-valid'=>'', 'placeholder'=>'Enter Client Name' )) }} 
								<span class="custom-error client_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="application">Application</label>
								{{ Form::text('application', '', array('class' => 'form-control', 'autocomplete'=>'off', 'data-valid'=>'', 'placeholder'=>'Enter Application' )) }} 
								<span class="custom-error application_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="installment_name">Installment Name <span class="span_req">*</span></label>
								{{ Form::text('installment_name', '', array('class' => 'form-control', 'autocomplete'=>'off', 'data-valid'=>'required', 'placeholder'=>'Enter Installment Name' )) }} 
								<span class="custom-error installment_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="installment_date">Installment Date <span class="span_req">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"> 
										<div class="input-group-text">
											<i class="fas fa-calendar-alt"></i>
										</div>
									</div>
									{{ Form::text('installment_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
								</div>
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
								<span class="custom-error installment_date_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="fees_type_sec">
								<div class="fee_type_row">
									<div class="custom_type_col">
										<div class="feetype_field">
											<div class="form-group">
												<label for="fee_type">Fee Type <span class="span_req">*</span></label>
											</div>
										</div>
										<div class="feeamount_field">
											<div class="form-group">
												<label for="fee_amount">Fee Amount <span class="span_req">*</span></label>
											</div>
										</div>
										<div class="commission_field">
											<div class="form-group">
												<label for="commission_percent">Commission %</label>
											</div>
										</div>
										<div class="remove_field">
											<div class="form-group">
											</div>
										</div>
									</div>
									<div class="fees_type_col custom_type_col">
										<div class="feetype_field">
											<div class="form-group">
												<select class="form-control select2" name="fee_type" data-valid="required">
													<option value="">Select Fee Type</option>
														@foreach(\App\FeeType::all() as $feetypes)
												<option @if($feetypes->name == 'Tution fees') selected @endif value="{{$feetypes->name}}">{{$feetypes->name}}</option>
												@endforeach
												</select>
											</div>
										</div>
										<div class="feeamount_field">
											<div class="form-group">
												{{ Form::text('fee_amount', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'0.00' )) }}
											</div>
										</div>
										<div class="commission_field">
											<div class="form-group">
												{{ Form::text('commission_percent', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'0.00' )) }}
											</div>
										</div>
										<div class="remove_field">	
											<a href="javascript:;" class="remove_btn"><i class="fa fa-trash"></i></a>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="discount_row">
									<div class="discount_col custom_type_col">
										<div class="feetype_field">
											<div class="form-group">  
												<input class="form-control" placeholder="Discount" disabled />
											</div>
										</div>
										<div class="feeamount_field">
											<div class="form-group">
												{{ Form::text('discount_amount', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'0.00' )) }}
											</div>
										</div>
										<div class="commission_field">
											<div class="form-group">
												{{ Form::text('dispcunt_commission_percent', '', array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'0.00' )) }}
											</div> 
										</div>
										<div class="remove_field">
											<a href="javascript:;" class="remove_btn"><i class="fa fa-trash"></i></a>
										</div>
									</div> 
									<div class="clearfix"></div>
								</div> 
							</div>
						</div>	
						<div class="col-12 col-md-12 col-lg-12">
							<div class="divider"></div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="add_fee_type">
								<a href="javascript:;" class="btn btn-outline-primary fee_type_btn"><i class="fa fa-plus"></i> Add Fee</a>
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 text-right">
							<div class="total_fee">
								<h4>Total Fee (USD)</h4>
								<span>11.00</span>
							</div>
							<div class="net_fee">
								<span class="span_label">Net Fee</span>
								<span class="span_value">0.00</span>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="divider"></div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="schedule_title">
								<h4>Setup Invoice Scheduling</h4>
							</div>
							<span class="schedule_note"><i class="fa fa-explanation-circle"></i> Schedule your Invoices by selecting an Invoice date for this installment.</span>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group"> 
								<label for="invoice_date">Invoice Date</label>
								<div class="input-group">
									<div class="input-group-prepend"> 
										<div class="input-group-text">
											<i class="fas fa-calendar-alt"></i>
										</div>
									</div>
									{{ Form::text('invoice_date', '', array('class' => 'form-control datepicker', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Select Date' )) }}
								</div>
								<span class="span_note">Date must be in YYYY-MM-DD (2012-12-22) format.</span>
								<span class="custom-error installment_date_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" value="Allow clients to upload documents from client portal" name="allow_upload_docu">
									<label class="form-check-label" for="allow_upload_docu">Auto Invoicing</label>
								</div>
								<span class="schedule_note"><i class="fa fa-explanation-circle"></i> Enabling Auto Invoicing will automatically create unpaid invoices at above stated Invoice Date.</span>
							</div>
						</div>	
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="fee_type">Invoice Type <span class="span_req">*</span></label>
								<select class="form-control select2" name="fee_type" data-valid="required">
									<option value="">Select Invoice Type</option>
									<option value="Net Claim">Net Claim</option>
									<option value="Gross Claim">Gross Claim</option>
								</select>
							</div>
						</div>
					</div> 
					<div class="clearfix"></div>
					<div class="divider"></div>					
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('paymentform')" type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>  
			</div>
		</div>
	</div>
</div>


<div id="applicationemailmodal"  data-backdrop="static" data-keyboard="false" class="modal fade custom_modal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="clientModalLabel">Compose Email</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" name="appkicationsendmail" id="appkicationsendmail" action="{{URL::to('/admin/application-sendmail')}}" autocomplete="off" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="client_id" value="{{$fetchedData->id}}">
				<input type="hidden" id="type" name="type" value="application">
				<input type="hidden" id="appointid" name="noteid" value="">
				<input type="hidden"  name="atype" value="application">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="email_from">From <span class="span_req">*</span></label>
								{{ Form::text('email_from', 'support@digitrex.live', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter From' )) }}
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
								<input type="text" readonly class="form-control" name="to" value="{{$fetchedData->first_name}} {{$fetchedData->last_name}}">
								<input type="hidden" class="form-control" name="to" value="{{$fetchedData->email}}">
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="email_cc">CC </label>
								<select data-valid="" class="js-data-example-ajaxcc" name="email_cc[]"></select>
								
								@if ($errors->has('email_cc'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('email_cc') }}</strong>
									</span> 
								@endif
							</div>
						</div>
						
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="template">Templates </label>
								<select data-valid="" class="form-control select2 selectapplicationtemplate" name="template">
									<option value="">Select</option>
									@foreach(\App\CrmEmailTemplate::all() as $list)
										<option value="{{$list->id}}">{{$list->name}}</option>
									@endforeach
								</select>
								
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="subject">Subject <span class="span_req">*</span></label>
								{{ Form::text('subject', '', array('class' => 'form-control selectedappsubject', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Subject' )) }}
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
								<textarea class="summernote-simple selectedmessage" name="message"></textarea>
								@if ($errors->has('message'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('message') }}</strong>
									</span>  
								@endif
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('appkicationsendmail')" type="button" class="btn btn-primary">Send</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- Education Modal -->
<div class="modal fade custom_modal" id="new_fee_option" tabindex="-1" role="dialog" aria-labelledby="feeoptionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="feeoptionModalLabel">Add New Fee Option</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{URL::to('/admin/savefee')}}" name="feeform" id="feeform" autocomplete="off" enctype="multipart/form-data">
				@csrf 
				<input type="hidden" name="product_id" value="{{$fetchedData->id}}">
					<div class="row">
						<div class="col-12 col-md-4 col-lg-4">
							<div class="form-group">
								<label for="fee_option_name">Fee Option Name <span class="span_req">*</span></label> 	
								{{ Form::text('fee_option_name', '', array('class' => 'form-control selectedappsubject', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Fee Option Name' )) }}
								<span class="custom-error feeoption_name_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-4 col-lg-4">
							<div class="form-group">
								<label for="country_residency">Country of Residency <span class="span_req">*</span></label> 
								<select class="form-control residencyelect2" name="country_residency" data-valid="required">
								<option value="">Select Country</option>
								<?php
									foreach(\App\Country::all() as $list){
										?>
										<option @if(@$list->name == 'Australia') selected @endif value="{{@$list->name}}">{{@$list->name}}</option>
										<?php
									}
									?>
								</select>
								<span class="custom-error country_residency_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-4 col-lg-4">
							<div class="form-group">
								<label for="degree_level">Installment Type <span class="span_req">*</span></label> 
								<select data-valid="required" class="form-control degree_level installment_type select2" name="degree_level">
									<option value="">Select Type</option>
									<option value="Full Fee">Full Fee</option>
									<option value="Per Year">Per Year</option>
									<option value="Per Month">Per Month</option>
									<option value="Per Term">Per Term</option>
									<option value="Per Trimester">Per Trimester</option>
									<option value="Per Semester">Per Semester</option>
									<option value="Per Week">Per Week</option>
									<option value="Installment">Installment</option>
								</select>
								<span class="custom-error degree_level_error" role="alert">
									<strong></strong>
								</span> 
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="table-responsive"> 
								<table class="table text_wrap" id="productitemview">
									<thead>
										<tr> 
											<th>Fee Type <span class="span_req">*</span></th>
											<th>Installment Amount <span class="span_req">*</span></th>
											<th>Installments <span class="span_req">*</span></th>
											<th>Total Fee</th>
											<th>Claimable Terms</th>
											<th>Commission %</th>
											<th>Add in quotation</th>
								
										</tr> 
									</thead>
									<tbody class="tdata">
										<tr class="add_fee_option cus_fee_option">
											<td>
												<select data-valid="required" class="form-control course_fee_type " name="course_fee_type[]">
													<option value="">Select Type</option>
												@foreach(\App\FeeType::all() as $feetypes)
												<option @if($feetypes->name == 'Tution fees') selected @endif value="{{$feetypes->name}}">{{$feetypes->name}}</option>
												@endforeach
												</select>
											</td>
											<td>
												<input type="number" value="0" class="form-control installment_amount" name="installment_amount[]">
											</td>
											<td>
												<input type="number" value="1" class="form-control installment" name="installment[]">
											</td>
											<td class="total_fee"><span>0.00</span><input value="0" type="hidden"  class="form-control total_fee_am" name="total_fee[]"></td>
											<td>
												<input type="number" value="1" class="form-control claimable_terms" name="claimable_terms[]">
											</td>
											<td>
												<input type="number" class="form-control commission" name="commission[]">
											</td>
											<td>
												<input value="1" class="add_quotation" type="checkbox" name="add_quotation[]">
											</td>
									
										</tr>
									</tbody>
									<tfoot>
										<tr>
											
											<td colspan="3" style="text-align: right;"><b>Net Total</b></td>
											<td class="net_totl text-info">0.00</td>
											<td colspan="3"></td>
										</tr>
									</tfoot>
								</table>	
							</div>
							<div class="fee_option_addbtn">
								<a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Add Fee</a>
							</div>
							
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<button onclick="customValidate('feeform')" type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div> 