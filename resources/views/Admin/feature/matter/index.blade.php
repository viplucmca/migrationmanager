@extends('layouts.admin')
@section('title', 'Matter')

@section('content')
<style>
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
			    <div class="col-3 col-md-3 col-lg-3">
			        	@include('../Elements/Admin/setting')
		        </div>
				<div class="col-9 col-md-9 col-lg-9">
					<div class="card">
						<div class="card-header">
							<h4>All Matters</h4>
                            <div class="card-header-action">
                                <a href="javascript:;" class="btn btn-theme btn-theme-sm filter_btn mr-2"><i class="fas fa-filter"></i> Filter</a>
                                <a href="{{route('admin.feature.matter.create')}}" class="btn btn-primary">Create Matter</a>
							</div>
						</div>
						<div class="card-body">
                            <div class="filter_panel"><h4>Search</h4>
                                <form action="{{URL::to('/admin/matter')}}" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="col-form-label" style="color:#4a5568 !important;">Matter Name</label>
                                                <input type="text" name="title" value="{{ old('title', Request::get('title')) }}" class="form-control" data-valid="" autocomplete="off" placeholder="Select Matter" id="title">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-top:35px;">
                                            <button type="submit" class="btn btn-primary btn-theme-lg">Search</button>
                                            <a class="btn btn-info" href="{{URL::to('/admin/matter')}}">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

							<div class="table-responsive common_table">
								<table class="table text_wrap">
								<thead>
									<tr>
										<th>Matter Name</th>
										<th></th>
									</tr>
								</thead>
								@if(@$totalData !== 0)
								<?php $i=0; ?>
								<tbody class="tdata">
								@foreach (@$lists as $list)
									<tr id="id_{{@$list->id}}">
										<td>{{ @$list->title == "" ? config('constants.empty') : str_limit(@$list->title, '50', '...') }}</td>
										<td>
											<div class="dropdown d-inline">
												<button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
												<div class="dropdown-menu">
													<a class="dropdown-item has-icon" href="{{URL::to('/admin/matter/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="far fa-edit"></i> Edit</a>
													<a class="dropdown-item has-icon" href="javascript:;" onClick="deleteAction({{@$list->id}}, 'matters')"><i class="fas fa-trash"></i> Delete</a>
													<?php
													$hasTemplate = \App\MatterEmailTemplate::where('matter_id', $list->id)->exists();
													?>
													@if($hasTemplate)
													<?php
													$Template_info = \App\MatterEmailTemplate::where('matter_id', $list->id)->first();
													?>
													<a class="dropdown-item has-icon" href="{{URL::to('/admin/matter_email_template/edit/'.$Template_info->id.'/'.$list->id)}}"><i class="far fa-edit"></i> Edit First Email</a>
													@else
													<a class="dropdown-item has-icon" href="{{URL::to('/admin/matter_email_template/create/'.@$list->id) }}"><i class="far fa-edit"></i> Create First Email</a>
													@endif
												</div>
											</div>
										</td>
									</tr>
								@endforeach
								</tbody>
								@else
								<tbody>
									<tr>
										<td style="text-align:center;" colspan="7">
											No Record found
										</td>
									</tr>
								</tbody>
								@endif
							</table>
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

	$('.cb-element').change(function () {
        if ($('.cb-element:checked').length == $('.cb-element').length){
            $('#checkbox-all').prop('checked',true);
        } else {
            $('#checkbox-all').prop('checked',false);
        }
    });
});
</script>
@endsection
