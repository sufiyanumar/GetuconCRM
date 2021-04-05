@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Add Organization</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-file-text mr-2 fs-14"></i>Organizations</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Add Organization</a></li>
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
				<h3 class="card-title">Organization Information</h3>
			</div>
			<div class="card-body">
				<form action="{{url('/create-organization')}}" method="POST" id="createOrganization" enctype="multipart/form-data">
					@csrf
					<div class="row mb-5">
						<div class="col-lg-4 col-md-4">
							<label class="form-label">Add Company Logo</label>
							<input type="file" name="logo" />
						</div>
					</div>
					<div class="row border">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Organization Name</label>
								<div class="input-group">
									<input type="text" name="name" class="form-control" placeholder="John Corporate" value="{{old('name')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Phone</label>
								<div class="input-group">
									<input type="number" name="phone" class="form-control" placeholder="11334455" value="{{old('phone')}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Email</label>
								<div class="input-group">
									<input type="text" name="email" class="form-control" placeholder="JohnCorporate@emil.com" value="{{old('email')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">GSM</label>
								<div class="input-group">
									<input type="text" name="gsm" class="form-control" placeholder="11334455" value="{{old('gsm')}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Address</label>
								<div class="input-group">
									<input type="text" name="address" class="form-control" placeholder="Street 19 Block 6" value="{{old('address')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2">
							<div class="form-group">
								<label class="form-label">City</label>
								<div class="input-group">
									<input type="text" name="city" class="form-control" placeholder="Istanbul" value="{{old('city')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2">
							<div class="form-group">
								<label class="form-label">Zip Code</label>
								<div class="input-group">
									<input type="number" name="zip_code" class="form-control" placeholder="73500" value="{{old('zip_code')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2">
							<div class="form-group">
								<label class="form-label">Rating </label>
								<div class="input-group">
									<select class="form-control" name="rating" id="rating">
										<option value="1" <?php if (old('rating') == 1) echo 'selected'; ?>>Good Client</option>
										<option value="2" <?php if (old('rating') == 2) echo 'selected'; ?>>Normal Client</option>
										<option value="3" <?php if (old('rating') == 3) echo 'selected'; ?>>Blacklist Client</option>
									</select>
									<!-- <input type="number" name="rating" class="form-control" placeholder="0" value="{{old('rating')}}" max="3"> -->
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<div class="form-label">Contract</div>
								<label class="custom-switch">
									<input type="checkbox" id="contractToggle" name="contractToggle" class="custom-switch-input" <?php if (old('contract')) echo 'Checked'; ?>>
									<span class="custom-switch-indicator"></span>
									<span class="custom-switch-description"></span>
								</label>
							</div>
						</div>
					</div>
			</div>
			<div id="isContract" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">Contract Information</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Contract</label>
								<div class="input-group">
									<input type="text" name="contract" class="form-control" placeholder="ABC Contract" value="{{old('contract')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Contract Frequency</label>
								<div class="input-group">
									<input type="number" name="frequency" class="form-control" placeholder="5" value="{{old('frequency')}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Contract Start Date</label>
								<div class="input-group">
									<input type="date" name="start_date" class="form-control" value="{{old('start_date')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Contract End Date</label>
								<div class="input-group">
									<input type="date" name="end_date" class="form-control" value="{{old('end_date')}}">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Contract Price</label>
								<div class="input-group">
									<input type="number" name="price" class="form-control" placeholder="5000" value="{{old('price')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">Per 15 minutes</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Contract Price</label>
								<div class="input-group">
									<input type="number" name="price_monthly" class="form-control" placeholder="5000" value="{{old('price_monthly')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">Monthly</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 border">
							<div class="form-group">
								<label class="form-label">Transport Price</label>
								<div class="input-group">
									<input type="number" name="transport_price" class="form-control" placeholder="400" value="{{old('transport_price')}}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<button type="submit" class="btn btn-primary mt-4 mb-0 float-right">Submit</button>
					</div>
				</div>
			</div>
			</form>
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
<script>
	$('#contractToggle').on('change', function() {
		var isTranslate = $("#contractToggle").is(":checked");
		if (isTranslate) {
			$('#isContract').css('display', 'block');
		} else
			$('#isContract').css('display', 'none');

	});
	$(document).ready(function() {
		var isTranslate = $("#contractToggle").is(":checked");
		if (isTranslate) {
			$('#isContract').css('display', 'block');
		} else
			$('#isContract').css('display', 'none');
	});
</script>
@endsection