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
							<h4>All Active Agents</h4>
							<div class="card-header-action">
								<a href="{{route('admin.agents.create')}}" class="btn btn-primary">Create Agent</a>
							</div>
						</div>
						<div class="card-body">
							<ul class="nav nav-pills" id="client_tabs" role="tablist">
								<li class="nav-item is_checked_clientn">
									<a class="nav-link active" id="active-tab"  href="{{URL::to('/admin/agents/active')}}" >Active</a>
								</li>
								<li class="nav-item is_checked_clientn">
									<a class="nav-link" id="inactive-tab"  href="{{URL::to('/admin/agents/inactive')}}" >Inactive</a>
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
													<?php $i=0; ?>
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
																<?php if( isset($list->id) && $list->id != 1) { ?>
                                                                    <a class="dropdown-item has-icon" href="javascript:;" onclick="deleteActionL({{$list->id}}, 'admins')"><i class="fas fa-trash"></i> Inactive</a>
                                                                <?php } ?>
                                                            </div>
														</div>
													</td>
												</tr>
												<?php $i++; ?>
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

<div id="emailmodal" class="modal fade custom_modal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="clientModalLabel">Compose Email</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" name="sendmail" action="{{URL::to('/admin/sendmail')}}" autocomplete="off" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="type" value="agent">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="email_from">From <span class="span_req">*</span></label>
								<input type="text" name="email_from" value="support@digitrex.live" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter From">
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
								<select data-valid="required" class="js-data-example-ajax" name="email_to[]"></select>

								@if ($errors->has('email_to'))
									<span class="custom-error" role="alert">
										<strong>{{ @$errors->first('email_to') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="email_cc">CC </label>
								<select data-valid="" class="js-data-example-ajaxccdd" name="email_cc[]"></select>

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
								<select data-valid="" class="form-control select2 selecttemplate" name="template">
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
								<input type="text" name="subject" value="" class="form-control selectedsubject" data-valid="required" autocomplete="off" placeholder="Enter Subject">
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
							<button onclick="customValidate('sendmail')" type="button" class="btn btn-primary">Send</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade custom_modal" id="openimportmodal" tabindex="-1" role="dialog" aria-labelledby="create_interestModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="interestModalLabel">Import Agents</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				 <div class="col-md-12">
					<h5>Business</h5>
					<a href="{{URL::to('admin/agents/import/business')}}" style="background-color: transparent;color: #9c9c9c;fill: #9c9c9c;width: 48%;border: 1px solid #9c9c9c;display: inline-flex;" class="btn btn-info defaultButton ghostButton">Import Business Agents</a>
				 </div>
				  <div class="col-md-12" style="margin-top: 20px!important;">
				  <h5>Individual</h5>
					<a href="{{URL::to('admin/agents/import/individual')}}" style="background-color: transparent;color: #9c9c9c;fill: #9c9c9c;width: 48%;border: 1px solid #9c9c9c;display: inline-flex;" class="btn btn-info defaultButton ghostButton">Import Individual Agents</a>
				 </div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script>
    function deleteActionL( id, table ) {
		var conf = confirm('Are you sure, you would like to inactive the agent?');
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
jQuery(document).ready(function($){
	$(document).delegate('.openimportmodal','click', function(){
		$('#openimportmodal').modal('show');
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
		$('.is_checked_client').show();
		$('.is_checked_clientn').hide();
      } else {
        all.prop('checked', false);
		$('.is_checked_client').hide();
		$('.is_checked_clientn').show();
      }
    } else {
      if (checked_length >= total) {
        dad.prop('checked', true);
			$('.is_checked_client').show();
		$('.is_checked_clientn').hide();
      } else {
        dad.prop('checked', false);
		$('.is_checked_client').hide();
		$('.is_checked_clientn').show();
      }
    }
  });
});

$('.cb-element').change(function () {

 if ($('.cb-element:checked').length == $('.cb-element').length){
  $('#checkbox-all').prop('checked',true);
 }
 else {
  $('#checkbox-all').prop('checked',false);
 }

 if ($('.cb-element:checked').length > 0){
		$('.is_checked_client').show();
		$('.is_checked_clientn').hide();
	}else{
		$('.is_checked_client').hide();
		$('.is_checked_clientn').show();
	}
});
$(document).delegate('.emailmodal', 'click', function(){

	$('#emailmodal').modal('show');
	var array = [];
	var data = [];
	$('.cb-element:checked').each(function(){

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

    "</div>",
  title: name
				});



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
			  return {
				results: data.items
			  };

			},
			 cache: true

		  },
	templateResult: formatRepo,
	templateSelection: formatRepoSelection
});

$('.js-data-example-ajaxccdd').select2({
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
