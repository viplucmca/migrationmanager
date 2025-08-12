@extends('layouts.admin')
@section('title', 'Clients Matters')

@section('content')
<style>
.ag-space-between {
    justify-content: space-between;
}
.ag-align-center {
    align-items: center;
}
.ag-flex {
    display: flex;
}
.ag-align-start {
    align-items: flex-start;
}
.ag-flex-column {
    flex-direction: column;
}
.col-hr-1 {
    margin-right: 5px!important;
}
.text-semi-bold {
    font-weight: 600!important;
}
.small, small {
    font-size: 85%;
}
.ag-align-end {
    align-items: flex-end;
}

.ui.yellow.label, .ui.yellow.labels .label {
    background-color: #fbbd08!important;
    border-color: #fbbd08!important;
    color: #fff!important;
}
.ui.label:last-child {
    margin-right: 0;
}
.ui.label:first-child {
    margin-left: 0;
}
.field .ui.label {
    padding-left: 0.78571429em;
    padding-right: 0.78571429em;
}

.ag-list__title{background-color: #fcfcfc;border: 1px solid #f2f2f2;padding: 0.8rem 1.2rem;}
.ag-list__item{font-size: 12px;margin: 0;padding: 0.8rem 2.6rem;}
.filter_panel {background: #f7f7f7;margin-bottom: 10px;border: 1pxsolid #eee;display: none;}
.card .card-body .filter_panel { padding: 20px;}
.tdCls {white-space: initial;}
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
							<h4>All Clients Matters</h4>
							<div class="card-header-action">
								<a href="javascript:;" class="btn btn-theme btn-theme-sm filter_btn"><i class="fas fa-filter"></i> Filter</a>
							</div>
						</div>
						<div class="card-body">
                            <div class="tab-content" id="clientContent">
                                <div class="filter_panel">
                                    <h4>Search By Details</h4>
                                    <form action="{{URL::to('/admin/clientsmatterslist')}}" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="matter" class="col-form-label" style="color:#000;">Matter</label>
                                                    <select class="form-control" name="sel_matter_id">
                                                        <option value="">Select Matter</option>
                                                        @foreach(\App\Matter::orderBy('title', 'asc')->get() as $matter)
                                                        <option value="{{ $matter->id }}" {{ request('sel_matter_id') == $matter->id ? 'selected' : '' }}>{{ $matter->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="pnr" class="col-form-label" style="color:#000;">Client ID</label>
                                                    {{ Form::text('client_id', Request::get('client_id'), array('class' => 'form-control', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Client ID', 'id' => 'client_id' )) }}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company_name" class="col-form-label" style="color:#000;">Client Name</label>
                                                    {{ Form::text('name', Request::get('name'), array('class' => 'form-control agent_company_name', 'data-valid'=>'', 'autocomplete'=>'off','placeholder'=>'Name', 'id' => 'name' )) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                {{ Form::submit('Search', ['class'=>'btn btn-primary btn-theme-lg' ]) }}
                                                <a class="btn btn-info" href="{{URL::to('/admin/clientsmatterslist')}}">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								<div class="tab-pane fade show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
									<div class="table-responsive common_table client_table_data">
										<table class="table text_wrap">
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
                                                    <td class="tdCls"><a href="{{URL::to('/admin/clients/detail/'.base64_encode(convert_uuencode(@$list->client_id)) )}}">{{ @$list->first_name == "" ? config('constants.empty') : str_limit(@$list->first_name, '50', '...') }} {{ @$list->last_name == "" ? config('constants.empty') : str_limit(@$list->last_name, '50', '...') }} </a></td>
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
											</tbody>
											@else
											<tbody>
												<tr>
													<td style="text-align:center;" colspan="17">
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
@endsection
@section('scripts')
<script>
jQuery(document).ready(function($){
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
