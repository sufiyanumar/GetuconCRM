@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('text-editor/trumbowyg.min.css')}}">
<link rel="stylesheet" href="{{asset('drop-zone/dropzone.css')}}">
<style>
	.trumbowyg-box,
	.trumbowyg-editor {
		min-height: 150px;
	}
</style>
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
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<div class="form-label">Translate</div>
								<label class="custom-switch">
									<input type="checkbox" id="translateToggle" name="translateToggle" class="custom-switch-input">
									<span class="custom-switch-indicator"></span>
									<span class="custom-switch-description"></span>
								</label>
							</div>
						</div>
						<div id="isTranslate" class="col-lg-12 col-md-12" style="display:none;">
							<div class="form-group">
								<label class="form-label">Translation</label>
								<div class="input-group">
									<textarea id="translate" name="translate" class="form-control">{{old('translate')}}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Organization</label>
								<select id="organization" name="organization" class="form-control">
									@if(old('organization'))
									<option value="{{old('organization')}}" selected="selected">
										{{ App\Organization::where('id', old('organization'))->value('org_name') }}
									</option>
									@else
									<option value="{{auth()->user()->org_id}}" selected="selected">
										{{ App\Organization::where('id', auth()->user()->org_id)->value('org_name') }}
									</option>
									@endif
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Ticketholder (Client)</label>
								<select id="users" name="user" class="form-control">
									@if(old('user'))
									<option value="{{old('user')}}" selected="selected">
										{{ App\User::where('id', old('user'))->value('first_name') }}
									</option>
									@else
									<option value="{{auth()->user()->id}}" selected="selected">
										{{ App\User::where('id', auth()->user()->id)->value('first_name') }}
									</option>
									@endif
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Assigned to (Internal)</label>
								<select id="personnel" name="personnel" class="form-control">
									@if(old('personnel'))
									<option value="{{old('personnel')}}" selected="selected">
										{{ App\User::where('id', old('personnel'))->value('first_name') }}
									</option>
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Status</label>
								<select name="status" class="form-control">
									@foreach($data['status'] as $status)
									<option value="{{$status->id}}" <?php if (old('status')) {
																		if (old('status') == $status->id) {
																			echo 'selected';
																		}
																	} ?>>
										{{$status->name}}
									</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Priority</label>
								<select name="priority" class="form-control">
									<option value="4" selcted>Low</option>
									<option value="1">Normal</option>
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
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Due Date</label>
								<input class="form-control" type="date" name="due_date" value="{{old('due_date')}}">
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Transport Price</label>
								<input class="form-control" type="number" name="transport_price" value="{{old('transport_price')}}">
							</div>
						</div>
					</div>
					<div class="row">
						@if(auth()->user()->role_id ==1)
						<div class="col-lg-3 col-md-3">
							<h4>Effort</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Good Will</label>
								<select name="good_will" class="form-control">
									@foreach($data['goodWill'] as $goodWill)
									<option value="{{$goodWill->frequency}}">{{$goodWill->frequency}}%</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Coding</label>
								<div class="input-group">
									<input class="form-control" type="number" name="coding_hours" value="{{old('coding_hours')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">hours</div>
									</div>
									<input class="form-control" type="number" name="coding_mints" value="{{old('coding_mints')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">minutes</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Consulting</label>
								<div class="input-group">
									<input class="form-control" type="number" name="consulting_hours" value="{{old('consulting_hours')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">hours</div>
									</div>
									<input class="form-control" type="number" name="consulting_mints" value="{{old('consulting_mints')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">minutes</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Testing</label>
								<div class="input-group">
									<input class="form-control" type="number" name="testing_hours" value="{{old('testing_hours')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">hours</div>
									</div>
									<input class="form-control" type="number" name="testing_mints" value="{{old('testing_mints')}}">
									<div class="input-group-prepend">
										<div class="input-group-text">minutes</div>
									</div>
								</div>
							</div>
						</div>
						@endif
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
	$('#description').trumbowyg({
		autogrow: true
	});
	$('#translate').trumbowyg({
		autogrow: true
	});
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
		acceptedFiles: 'image/jpeg,image/png,image/jpg,.pdf,.csv,.ppt,.pptx,.doc,.docx,.mp4,.xlsx,.xlsm,.xltx,.xlsb',
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