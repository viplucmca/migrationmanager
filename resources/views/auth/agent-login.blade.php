@extends('layouts.agent-login')

@section('title', 'Agent Login')

@section('content')
	
	<section class="section">
		<div class="container mt-5">
			<div class="row">
				<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Login</h4>
						</div>
						<div class="card-body">
							<div class="server-error"> 
								@include('../Elements/flash-message')
							</div>
							
							<form action="{{URL::to('agent/login')}}" method="post" name="admin_login">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label for="email">Email</label>
									<input id="email" placeholder="Email" type="email" class="form-control" name="email" tabindex="1" value="{{ (Cookie::get('email') !='' && !old('email')) ? Cookie::get('email') : old('email')  }}" required autofocus>
									@if ($errors->has('email'))
									<div style="color: #dc3545;">
									 {{ $errors->first('email') }}
									</div>
									@endif
								</div>
								<div class="form-group">
									<div class="d-block">
										<label for="password" class="control-label">Password</label>
										<div class="float-right">
											<a href="#" class="text-small">Forgot Password?</a>
										</div>
									</div>
									<input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Password" value="{{ (Cookie::get('password') !='' && !old('password')) ? Cookie::get('password') : old('password')  }}" required>
									<div class="invalid-feedback">
									  please fill in your password
									</div>
								</div>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" @if(Cookie::get('email') != '' && Cookie::get('password') != '') checked  @endif>
										<label class="custom-control-label" for="remember-me">Remember Me</label>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Login</button>
								</div>
							{{ Form::close() }}
						</div>
					</div>
				
				</div>
			</div>
		</div>
	</section>
	
@endsection