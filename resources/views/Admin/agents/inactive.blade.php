@extends('layouts.admin')
@section('title', 'Agents')

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
							<h4>All Inactive Agents</h4>
						</div>
						<div class="card-body">
							<ul class="nav nav-pills" id="client_tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link" id="active-tab"  href="{{URL::to('/admin/agents/active')}}" >Active</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" id="inactive-tab"  href="{{URL::to('/admin/agents/inactive')}}" >Inactive</a>
								</li>
							</ul>
							<div class="tab-content" id="clientContent">
								<div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
									<div class="table-responsive common_table">
										<table class="table text_wrap">
											<thead>
												<tr>
													<th>Business Name</th>
                                                    <th>Agent Name</th>
													<th>MARN NO</th>
													<th>Legal Practitioner No</th>
                                                     <th>ABN NO</th>
													<th>Phone</th>
													<th>Email</th>
													<th></th>
												</tr>
											</thead>

											<tbody class="tdata">
												@if(@$totalData !== 0)
												@foreach (@$lists as $list)
												<tr id="id_{{@$list->id}}">
                                                    <td style="white-space: initial;">{{ @$list->company_name == "" ? config('constants.empty') : str_limit(@$list->company_name, '50', '...') }}</td>
                                                    <td style="white-space: initial;">
                                                        <a href="{{ URL::to('/admin/agent/detail/' . base64_encode(convert_uuencode(@$list->id))) }}">
                                                            {{ (@$list->first_name == "" && @$list->last_name == "")
                                                                ? config('constants.empty')
                                                                : str_limit(trim(@$list->first_name . ' ' . @$list->last_name), 50, '...') }}
                                                        </a>
                                                    </td>
                                                    <td style="white-space: initial;">{{ @$list->marn_number == "" ? config('constants.empty') : str_limit(@$list->marn_number, '50', '...') }}</td>
													<td style="white-space: initial;">{{ @$list->legal_practitioner_number == "" ? config('constants.empty') : str_limit(@$list->legal_practitioner_number, '50', '...') }}</td>
                                                    <td style="white-space: initial;">{{ @$list->ABN_number == "" ? config('constants.empty') : str_limit(@$list->ABN_number, '50', '...') }}</td>


													<td style="white-space: initial;">{{ @$list->phone == "" ? config('constants.empty') : str_limit(@$list->phone, '50', '...') }}</td>
													<td style="white-space: initial;">{{ @$list->email == "" ? config('constants.empty') : str_limit(@$list->email, '50', '...') }}</td>
													<td>
														<div class="dropdown d-inline">
															<button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
															<div class="dropdown-menu">
																<a class="dropdown-item has-icon" href="{{URL::to('/admin/agents/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="far fa-edit"></i> Edit</a>
																<a class="dropdown-item has-icon" href="javascript:;" onclick="deleteActionL({{$list->id}}, 'admins')"><i class="fas fa-trash"></i> Active</a>

															</div>
														</div>
													</td>
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
								<input type="text" name="email_from" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter From">
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
								<input type="text" name="email_to" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter To">
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
								<input type="text" name="subject" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Subject">
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
    function deleteActionL( id, table ) {
		var conf = confirm('Are you sure, you would like to active the agent?');
		if(conf){
			if(id == '') {
				alert('Please select ID to delete the record.');
				return false;
			} else {
				$('.popuploader').show();
				$(".server-error").html(''); //remove server error.
				$(".custom-error-msg").html(''); //remove custom error.
				$.ajax({
					type:'post',
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url:site_url+'/admin/delete_action',
					data:{'id': id, 'table' : table},
					success:function(resp) {
						$('.popuploader').hide();
						var obj = $.parseJSON(resp);
						if(obj.status == 1) {
							$("#id_"+id).remove();
							$("#quid_"+id).remove();
							//show success msg
								var html = successMessage(obj.message);
								$(".custom-error-msg").html(html);

							//show count
								var old_count = $(".count").text();
								var new_count = old_count - 1;
								$(".count").text(new_count);

							//when all data has been deleted
								if(new_count == 0){
									$(".tdata").html('<tr><td colspan="6">There are no data in this table.</td></tr>');
								}

								location.reload();
								// setTimeout(function(){
								// 	location.reload();
								// }, 3000);
						} else{
							var html = errorMessage(obj.message);
							$(".custom-error-msg").html(html);
						}
						$("#loader").hide();
					},
					beforeSend: function() {
						$("#loader").show();
					}
				});
				$('html, body').animate({scrollTop:0}, 'slow');
			}
		} else{
			$("#loader").hide();
		}
	}
</script>
@endsection
