@extends('layouts.admin')
@section('title', 'User')

@section('content')

<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-body">
			{{ Form::open(array('url' => 'admin/services/store', 'name'=>"add-service", 'autocomplete'=>'off', "enctype"=>"multipart/form-data")) }}
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4>Add Services</h4>
								<div class="card-header-action">
									<a href="{{route('admin.services.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6">
						<div class="card">
							<div class="card-body">
								<div class="form-group"> 
									<label for="title">Title</label>
									{{ Form::text('title', '', array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Service Name' )) }}
									@if ($errors->has('title'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('title') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label for="description">Description</label>
									<textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
									@if ($errors->has('description'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('description') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label for="parent">Parent</label>
									<select class="form-control" name="parent">
										<option value="0">None</option>
											<?php
												echo \App\Service::printTree($tree);
											?>
									</select>
									@if ($errors->has('parent'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('parent') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group"> 
									<label for="services_icon">Service Icon</label>
									{{ Form::text('services_icon', '', array('class' => 'form-control', 'autocomplete'=>'off','placeholder'=>'Enter Service Icon' )) }}
									@if ($errors->has('services_icon'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('services_icon') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group">
									<label>Service Image</label>
									<div class="custom-file">
										<input type="file" id="services_image" name="services_image" class="form-control" autocomplete="off" />
										<label class="custom-file-label" for="services_image">Choose file</label>
									</div>	
									@if ($errors->has('services_image'))
										<span class="custom-error" role="alert">
											<strong>{{ @$errors->first('services_image') }}</strong>
										</span> 
									@endif
								</div>
								<div class="form-group float-right">
									{{ Form::submit('Save Service', ['class'=>'btn btn-primary' ]) }}
								</div>
							</div>
						</div>
					</div>
				</div>
			 {{ Form::close() }}	
		</div>
	</section>
</div>

@endsection