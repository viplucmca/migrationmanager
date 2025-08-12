@extends('layouts.admin')
@section('title', 'Edit Promo Code')

@section('content')
<!-- Main Content -->
<style>
.date {
    max-width: 330px;
    font-size: 14px;
    line-height: 21px;
    margin: 0px auto;
    background: #d3d4ec;
    padding: 8px;
    border-radius: 5px;
}
</style>
<div class="main-content">
	<section class="section">
		<div class="section-body">
			<form action="{{ url('admin/promo-code/edit') }}" name="edit-promo-code" autocomplete="off" enctype="multipart/form-data" method="POST">
				@csrf
				<input type="hidden" name="id" value="{{ old('id', @$fetchedData->id) }}">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4>Edit Promo Code</h4>
								<div class="card-header-action">
									<a href="{{route('admin.feature.promocode.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
								</div>
							</div>
						</div>
					</div>
					 <div class="col-3 col-md-3 col-lg-3">
			        	@include('../Elements/Admin/setting')
    		        </div>
    				<div class="col-9 col-md-9 col-lg-9">
						<div class="card">
							<div class="card-body">
								<div id="accordion">
									<div class="accordion">
										<h4>Edit Promo Code</h4>

										<div class="accordion-body collapse show" id="primary_info" data-parent="#accordion">
											<div class="row">
												<div class="col-12 col-md-4 col-lg-4">
													<div class="form-group">
														<label for="title">Title <span class="span_req">*</span></label>
														<input type="text" name="title" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Title" value="{{ old('title', $fetchedData->title) }}">
														@if ($errors->has('title'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('title') }}</strong>
															</span>
														@endif
													</div>
												</div>
                                            </div>


                                            <div class="row">
												<div class="col-12 col-md-4 col-lg-4">
													<div class="form-group">
														<label for="code">Code <span class="span_req">*</span></label>
														<input type="text" name="code" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Code" value="{{ old('code', $fetchedData->code) }}">
														@if ($errors->has('code'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('code') }}</strong>
															</span>
														@endif
													</div>
												</div>
                                            </div>

                                            <input type="hidden" name="discount_percentage" value="100">
                                            <!--<div class="row">
												<div class="col-12 col-md-4 col-lg-4">
													<div class="form-group">
														<label for="discount_percentage">Discount(In Percentage) <span class="span_req">*</span></label>
														{{-- Form::number('discount_percentage', $fetchedData->discount_percentage, array('class' => 'form-control', 'data-valid'=>'required', 'autocomplete'=>'off','placeholder'=>'Enter Discount Percentage' )) --}}
														{{--@if ($errors->has('discount_percentage')) --}}
															<span class="custom-error" role="alert">
																<strong>{{-- @$errors->first('discount_percentage') -- }}</strong>
															</span>
														{{--@endif --}}
													</div>
												</div>
                                            </div>-->
										</div>
									</div>
								</div>
								<div class="form-group float-right">
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
@endsection
@section('scripts')

@endsection

