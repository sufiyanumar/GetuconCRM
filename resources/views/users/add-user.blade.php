@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Add User</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-file-text mr-2 fs-14"></i>Users</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Add User</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			@if($errors->any())
			@foreach($errors->all() as $error)
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
				</button>
				{{$error}}
			</div>
			@endforeach
			@endif
			<div class="card-header">
				<h3 class="card-title">Add User</h3>
			</div>
			<div class="card-body">
				<form action="{{url('/create-user')}}" method="post">
					@csrf
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Role</label>
								<select name="role" class="form-control custom-select select2">
									<option disabled selected>Select Role</option>
									@foreach($roles as $role)
									<option value="{{$role->id}}" <?php if (old('role')) {
																		if (old('role') == $role->id) {
																			echo 'selected';
																		}
																	} ?>>{{$role->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Organization</label>
								<select name="organization" class="form-control custom-select select2">
									<option disabled selected>Select Organization</option>
									@foreach($organizations as $organization)
									<option value="{{$organization->id}}" <?php if (old('organization')) {
																				if (old('organization') == $organization->id) {
																					echo 'selected';
																				}
																			} ?>>{{$organization->org_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">First Name</label>
								<div class="input-group">
									<input type="text" name="first_name" class="form-control" placeholder="John" value="{{old('first_name')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Last Name</label>
								<div class="input-group">
									<input type="text" name="last_name" class="form-control" placeholder="Smith" value="{{old('last_name')}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Phone</label>
								<div class="input-group">
									<input type="number" name="phone" class="form-control" placeholder="11334455" value="{{old('phone')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Email</label>
								<div class="input-group">
									<input type="email" name="email" class="form-control" placeholder="JohnSmith@email.com" value="{{old('email')}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Password</label>
								<div class="input-group">
									<input type="password" name="password" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Confirm Password</label>
								<div class="input-group">
									<input type="password" name="confirm_password" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<button type="submit" class="btn btn-primary mt-4 mb-0 float-right">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div><!-- end app-content-->
</div>
@endsection
@section('js')
<!--INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection