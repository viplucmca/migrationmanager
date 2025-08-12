@extends('layouts.admin')
@section('title', 'Audit Logs')

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
							<h4>Audit Logs</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table text_wrap">
									<thead>
										<tr>
											<th>ID</th>
											<th>Level</th>
											<th>Date</th>
											<th>User</th>
											<th>IP Address</th>
											<th>User Agent</th>
											<th>Message</th>
										</tr>
									</thead>
									<tbody class="tdata">
									@foreach($lists as $list)
										<tr>
											<td>{{$list->id}}</td>
											<td>@if($list->level == 'info')<span class="ag-label--circular" style="color: #008000;">Info</span>@elseif($list->level == 'critical')
												<span class="ag-label--circular" style="color: #e46363;">Critical</span>@elseif($list->level == 'warning')<span class="ag-label--circular" style="color: #ffbd72;">Warning</span>@endif</td>
											<td>{{date('d/m/Y', strtotime($list->created_at))}}</td>
											<td>
											<?php
											if($list->user_id != ''){
												$user = \App\Admin::where('id', $list->user_id)->first();
												if($user){
												?>
												<a href="#">{{$user->first_name}}</a>
												<?php
												}
											}
											?>
											</td>
											<td><a target="_blank" href="https://whatismyipaddress.com/ip/{{$list->ip_address}}">{{$list->ip_address}}</a></td>
											<td></td>
											<td>{{$list->message}}</td>
										</tr>
									@endforeach

									</tbody>
								</table>
							</div>

						</div>
						<div class="card-footer">{!! $lists->appends(\Request::except('page'))->render() !!}</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection
