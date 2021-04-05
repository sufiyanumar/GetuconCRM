@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Update User</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/users')}}"><i class="fe fe-file-text mr-2 fs-14"></i>User</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="{{url('/user'.'/'.$user->id)}}">{{$user->first_name}} {{$user->surname}}</a></li>
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
				<h3 class="card-title">Update User</h3>
			</div>
			<div class="card-body">
				<form action="{{url('/edit-user').'/'.$user->id}}" method="post">
					@csrf
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Role</label>
								<select name="role" class="form-control custom-select select2">
									@foreach($roles as $role)
									<option value="{{$role->id}}" <?php if ($user->role_id == $role->id) echo 'selected'; ?>>{{$role->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Organization</label>
								<select name="organization" class="form-control custom-select select2">
									@foreach($organizations as $organization)
									<option value="{{$organization->id}}" <?php if ($user->org_id == $organization->id) echo 'selected'; ?>>{{$organization->org_name}}</option>
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
									<input type="text" name="first_name" class="form-control" value="{{$user->first_name}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Last Name</label>
								<div class="input-group">
									<input type="text" name="last_name" class="form-control" value="{{$user->surname}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Phone</label>
								<div class="input-group">
									<input type="number" name="phone" class="form-control" value="{{$user->phone_no}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Email</label>
								<div class="input-group">
									<input type="email" name="email" class="form-control" value="{{$user->email}}">
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