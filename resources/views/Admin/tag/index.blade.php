@extends('layouts.admin')
@section('title', 'Tags')
 
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
				<div class="col-3 col-md-3 col-lg-3">
			        	@include('../Elements/Admin/setting')
		        </div>       
				<div class="col-9 col-md-9 col-lg-9">
					<div class="card">
						<div class="card-header">
							<h4>Tags</h4>
							<div class="card-header-action">
								<a href="{{route('admin.feature.tags.create')}}" class="btn btn-primary">Create Tag</a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive common_table"> 
								<table class="table text_wrap">
								<thead>
									<tr>
										
										<th>Name</th>
										<th>Created By</th>
										<th>Last Updated By</th>
										<th>Last Updated On</th>
										<th></th>
									</tr> 
								</thead>
								@if(@$totalData !== 0)
								<?php $i=0; ?>
								<tbody class="tdata">	
								@foreach (@$lists as $list)
									<tr id="id_{{@$list->id}}">
										
										<td>{{ @$list->name == "" ? config('constants.empty') : str_limit(@$list->name, '50', '...') }}</td> 	
										<td>{{@$list->createddetail->first_name}}</td> 	
										<td>{{@$list->updateddetail->first_name}}</td> 	
										<td>@if($list->created_at != '') {{date('Y-m-d', strtotime($list->created_at))}} @else - @endif</td> 	
										
										<td>
											<div class="dropdown d-inline">
												<button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
												<div class="dropdown-menu">
													<a class="dropdown-item has-icon" href="{{URL::to('/admin/tags/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="far fa-edit"></i> Edit</a>
													<a class="dropdown-item has-icon" href="javascript:;" onClick="deleteAction({{@$list->id}}, 'tags')"><i class="fas fa-trash"></i> Delete</a>
													
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
	$('.cb-element').change(function () {		
	if ($('.cb-element:checked').length == $('.cb-element').length){
	  $('#checkbox-all').prop('checked',true);
	}
	else {
	  $('#checkbox-all').prop('checked',false);
	}
	/* if ($('.cb-element:checked').length > 0){
			$('.is_checked_client').show();
			$('.is_checked_clientn').hide();
		}else{
			$('.is_checked_client').hide();
			$('.is_checked_clientn').show();
		} */
	});	
});	
</script>
@endsection