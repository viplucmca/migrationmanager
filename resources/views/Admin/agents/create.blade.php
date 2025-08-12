@extends('layouts.admin')
@section('title', 'Add New Agent')

@section('content')

<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-body">
			<form action="{{ url('admin/agents/store') }}" name="add-agents" autocomplete="off" enctype="multipart/form-data" method="POST">
				@csrf
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4>Add New Agent</h4>
								<div class="card-header-action">
									<a href="{{route('admin.agents.active')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-body">
								<div id="accordion">


									<div class="accordion">
										<div class="accordion-header" role="button" data-toggle="collapse" data-target="#personal_details" aria-expanded="true">
											<h4>Personal Details</h4>
										</div>
										<div class="accordion-body collapse show" id="personal_details" data-parent="#accordion">
											<div class="row">

												<div class="col-12 col-md-6 col-lg-6" >
													<div class="form-group">
														<label for="company_name">Business Name <span class="span_req">*</span></label>
														<input type="text" name="company_name" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Business Name">
														@if ($errors->has('company_name'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('company_name') }}</strong>
															</span>
														@endif
													</div>
												</div>

												<div class="col-12 col-md-6 col-lg-6 ">
													<div class="form-group">
														<label for="first_name">First Name <span class="span_req">*</span></label>
														<input type="text" name="first_name" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Agent First Name">
														@if ($errors->has('first_name'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('first_name') }}</strong>
															</span>
														@endif
													</div>
												</div>

                                                <div class="col-12 col-md-6 col-lg-6 ">
													<div class="form-group">
														<label for="last_name">Last Name <span class="span_req">*</span></label>
														<input type="text" name="last_name" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Agent Last Name">
														@if ($errors->has('last_name'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('last_name') }}</strong>
															</span>
														@endif
													</div>
												</div>

												<div class="col-12 col-md-6 col-lg-6 ">
													<div class="form-group">
														<label for="marn_number">MARN Number</label>
														<input type="text" name="marn_number" value="" class="form-control" autocomplete="off" placeholder="Enter MARN Number">
														@if ($errors->has('marn_number'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('marn_number') }}</strong>
															</span>
														@endif
													</div>
												</div>

                                                <div class="col-12 col-md-6 col-lg-6 ">
													<div class="form-group">
														<label for="legal_practitioner_number">Legal Practitioner Number</label>
														<input type="text" name="legal_practitioner_number" value="" class="form-control" autocomplete="off" placeholder="Enter Legal Practitioner Number">
														@if ($errors->has('legal_practitioner_number'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('legal_practitioner_number') }}</strong>
															</span>
														@endif
													</div>
												</div>


                                                <!--<div class="col-12 col-md-6 col-lg-6 ">
													<div class="form-group">
														<label for="exempt_person_reason">Exempt Person Reason</label>
														{{--Form::text('exempt_person_reason','', array('class' => 'form-control','autocomplete'=>'off','placeholder'=>'Enter Exempt Person Reason' ))--}}
														{{--@if ($errors->has('exempt_person_reason'))--}}
															<span class="custom-error" role="alert">
																<strong>{{--@$errors->first('exempt_person_reason')-- }}</strong>
															</span>
														{{--@endif--}}
													</div>
												</div>-->

                                                <div class="col-12 col-md-6 col-lg-6 ">
													<div class="form-group">
														<label for="ABN_number">ABN Number</label>
														<input type="text" name="ABN_number" value="" class="form-control" autocomplete="off" placeholder="Enter ABN Number">
														@if ($errors->has('ABN_number'))
															<span class="custom-error" role="alert">
																<strong>{{ @$errors->first('ABN_number') }}</strong>
															</span>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="accordion">
										<div class="accordion-header" role="button" data-toggle="collapse" data-target="#contact_details" aria-expanded="true">
											<h4>Contact Details</h4>
										</div>
										<div class="accordion-body collapse show" id="contact_details" data-parent="#accordion">
											<div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="email">Business Email <span class="span_req">*</span></label>
                                                        <input type="text" name="email" value="" class="form-control" data-valid="required" autocomplete="off" placeholder="Enter Business Email">
                                                        @if ($errors->has('email'))
                                                            <span class="custom-error" role="alert">
                                                                <strong>{{ @$errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="phone">Business Phone</label>
                                                        <input type="text" name="phone" value="" class="form-control" autocomplete="off" placeholder="Enter Business Phone">
                                                        @if ($errors->has('phone'))
                                                            <span class="custom-error" role="alert">
                                                                <strong>{{ @$errors->first('phone') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="business_mobile">Business Mobile</label>
                                                        <input type="text" name="business_mobile" value="" class="form-control" autocomplete="off" placeholder="Enter Business Mobile">
                                                        @if ($errors->has('business_mobile'))
                                                            <span class="custom-error" role="alert">
                                                                <strong>{{ @$errors->first('business_mobile') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="business_fax">Business Fax</label>
                                                        <input type="text" name="business_fax" value="" class="form-control" autocomplete="off" placeholder="Enter Fax">
                                                        @if ($errors->has('business_fax'))
                                                            <span class="custom-error" role="alert">
                                                                <strong>{{ @$errors->first('business_fax') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="address">Business Address</label>
                                                        <input type="text" name="address" value="" class="form-control" autocomplete="off" placeholder="Enter Business Address">
                                                        @if ($errors->has('address'))
                                                            <span class="custom-error" role="alert">
                                                                <strong>{{ @$errors->first('address') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="gender">Gender</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        @if ($errors->has('gender'))
                                                            <span class="custom-error" role="alert">
                                                                <strong>{{ @$errors->first('gender') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

											</div>
										</div>
									</div>

								</div>

								<div class="form-group float-right">
									<button type="submit" class="btn btn-primary">Save Agent</button>
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
<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
	  $('.if_image').hide();
    }
  };
</script>
@endsection
