@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('text-editor/trumbowyg.min.css')}}">
<link rel="stylesheet" href="{{asset('drop-zone/dropzone.css')}}">
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Add Ticket</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/tickets')}}"><i class="fe fe-file-text mr-2 fs-14"></i>Tickets</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Add Ticket</a></li>
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
				<h3 class="card-title">Ticket Information</h3>
			</div>
			<div class="card-body">
				<form action="{{url('/create-ticket')}}" method="POST" id="createTicket">
					@csrf
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Subject</label>
								<div class="input-group">
									<input type="text" name="name" class="form-control" placeholder="Subject" value="{{old('name')}}">
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Description</label>
								<div class="input-group">
									<textarea id="description" name="description" class="form-control">{{old('description')}}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Priority</label>
								<select name="priority" class="form-control">
									<option value="0">Low</option>
									<option value="1">Medium</option>
									<option value="2">High</option>
									<option value="3">Very High</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Category</label>
								<select name="category" class="form-control">
									@foreach($data['category'] as $category)
									<option value="{{$category->id}}" <?php if (old('category')) {
																			if (old('category') == $category->id) {
																				echo 'selected';
																			}
																		} ?>>{{$category->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div id="attachmentResponse">
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-lg-3 col-md-3">
						<h4>Attachments</h4>
					</div>
				</div>
				@if(in_array('CREATE_TICKET_ATTACHMENT', auth()->user()->Permissions))
				<div class="row">
					<div class="col-md-12">
						<form class="dropzone" id="ticketAttachments"> @csrf</form>
					</div>
				</div>
				@endif
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<button type="submit" id="createTicketButton" class="btn btn-primary mt-4 mb-0 float-right">Submit</button>

						<a href="{{url('/tickets')}}" class="btn btn-danger mt-4 mb-0 mr-4 float-right">Cancel</a>

					</div>
				</div>
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
<script src="{{asset('drop-zone/dropzone.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{asset('text-editor/trumbowyg.min.js')}}"></script>

<script>
	$('#description').trumbowyg();
	$('#translate').trumbowyg();
	$('#translateToggle').on('change', function() {
		var isTranslate = $("#translateToggle").is(":checked");
		if (isTranslate) {
			$('#isTranslate').css('display', 'block');
		} else
			$('#isTranslate').css('display', 'none');

	});
	Dropzone.autoDiscover = false;
	$('#ticketAttachments').dropzone({
		maxFiles: 5,
		parallelUploads: 10,
		uploadMultiple: true,
		addRemoveLinks: true,
		acceptedFiles: 'image/jpeg,image/png,image/jpg,.pdf,.csv',
		url: '/attachFiles',
		success: function(file, response) {
			if (response.error)
				toastr.error(response.error, 'Error');
			else {
				$.each(response.data, function(key, data) {
					$('#attachmentResponse').append('<input type="hidden" name="ticketAttachments[' + data.size + ']" value="' + data.link + '"/>');
				});
				toastr.success(response.success, 'Success');
			}
		}
	});
	$(document).ready(function() {
		$('#organization').select2({
			ajax: {
				url: '/getOrganizationsRawData',
				processResults: function(data, page) {
					return {
						results: data
					};
				}
			}
		});
		$('#personnel').select2({
			ajax: {
				url: '/getPersonnelRawData',
				processResults: function(data, page) {
					return {
						results: data
					};
				}
			}
		});
	});
	$('#organization').on('change', function() {
		var orgId = this.value;
		$('#users').select2({
			ajax: {
				url: '/getOrganizationUsersRawData/' + orgId + '?returnType=raw',
				processResults: function(data, page) {
					return {
						results: data
					};
				}
			}
		});
	});
	$('#createTicketButton').on('click', function() {
		$('#createTicket').submit();
	})
</script>
@endsection