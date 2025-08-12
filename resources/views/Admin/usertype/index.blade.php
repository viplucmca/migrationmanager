@extends('layouts.admin')
@section('title', 'User Type')

@section('content')

<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4>User Type</h4>
							<div class="card-header-action">
								<a href="{{route('admin.usertype.create')}}" class="btn btn-primary">Create User Type</a>
							</div>
						</div>
						<div class="card-body">
							<table class="table">
								<thead>
									<tr>
									 <th>User Type</th>
									  <th></th>
									</tr> 
								</thead>
								<tbody class="tdata">	
								@if(@$totalData !== 0)
								@foreach (@$lists as $list)
									<tr id="id_{{@$list->id}}"> 
										<td>{{ @$list->name == "" ? config('constants.empty') : str_limit(@$list->name, '50', '...') }}</td> 	
										<td>
											<div class="dropdown d-inline">
												<button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
												<div class="dropdown-menu">
													<a class="dropdown-item has-icon" href="{{URL::to('/admin/usertype/edit/'.base64_encode(convert_uuencode(@$list->id)))}}"><i class="far fa-edit"></i> Edit</a>
													<a class="dropdown-item has-icon" href="javascript:;" onClick="deleteAction({{@$list->id}}, 'user_types')"><i class="fas fa-trash"></i> Delete</a>
												</div>
											</div>								  
										</td>
									</tr>	
								@endforeach	
								</tbody>
								@else
								<tbody>
									<tr>
										<td style="text-align:center;" colspan="6">
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