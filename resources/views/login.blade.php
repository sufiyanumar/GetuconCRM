@extends('layouts.master2')
@section('css')
@endsection
@section('content')
<div class="page">
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6 d-none d-md-flex align-items-center" style="padding-left: 100px;">
						<div class="row">
							<h2 style="color:white;" class="display-4 mb-2 font-weight-bold text-center">GetuconIT<span class="text-thin">CRM</span></h2>
							<h4 style="color:white;" class="">
								Unser CRM ist ausgelegt für Google Chrome.
							</h4>
							<h4 class="mb-7 text-theme-light">
								<a href="https://www.google.com/intl/de_de/chrome/" target="_blank">
									Downloadlink für Google Chrome
								</a>
							</h4>
						</div>
					</div>	
				<div class="col-md-6">
						<div class="card border-info login ">
							<div class="text-white">
								<div class="card-body">
									@if($errors->any())
									@foreach($errors->all() as $error)
									<div class="alert alert-danger" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
										</button>
										{{$error}}
									</div>
									@endforeach
									@endif
									<h2  class="display-5 mb-2 font-weight-bold text-center text-theme"><strong>Login</strong></h2>
									<h4  class="mb-4 text-center text-theme">Sign In to your account</h4>
									<form method="POST" action="{{ route('login') }}">
										@csrf
										<div class="row">
											<div class="col-12 d-block mx-auto">
												<div class="input-group mb-4">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fe fe-user"></i>
														</div>
													</div>
													<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
												</div>
												<div class="input-group mb-4">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fe fe-lock"></i>
														</div>
													</div>
													<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
												</div>
												<div class="row">
													<div class="col-12">
														<button type="submit" class="btn  btn-theme btn-block px-4">Login <span class="fe fe-log-in"></span></button>
													</div>
													<!-- <div class="col-12 text-center">
														<a href="{{ url('')}}" class="btn btn-link box-shadow-0 px-0 text-white-80">Forgot password?</a>
													</div> -->
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
				</div>
		</div>
	</div>
</div>
@endsection
@section('js')
@endsection