@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('text-editor/trumbowyg.min.css')}}">
<link rel="stylesheet" href="{{asset('drop-zone/dropzone.css')}}">
<style>
	.alert-light-private {
		color: #8a6d3b;
		background-color: #FCF8E3;
		border-color: #FCF8E3;
	}

	.btn-private {
		color: #fff !important;
		background-color: #8a6d3b;
		border-color: #8a6d3b;
		box-shadow: 0 0px 10px -5px rgb(239 75 75 / 44%);
	}

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
		<h4 class="page-title mb-0">Update Ticket</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/tickets')}}"><i class="fe fe-file-text mr-2 fs-14"></i>Tickets</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">{{$ticket->name}}</a></li>
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
				<h3 class="card-title">Ticket Information &nbsp;#{{$ticket->id}}</h3>
			</div>
			<div class="card-body">
				<form action="{{url('/edit-ticket').'/'.$ticket->id}}" method="POST" id="updateTicket">
					@csrf
					@if(auth()->user()->role_id ==1)
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Subject</label>
								<div class="input-group">
									<input type="text" name="name" class="form-control" placeholder="Subject" value="{{$ticket->name}}">
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Description</label>
								<div class="input-group">
									<textarea id="description" name="description" class="form-control">{{$ticket->description}}@if (strpos($ticket->description, "<div>") !== false) {
										echo "</div>";
									@endif</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<div class="form-label">Translate</div>
								<label class="custom-switch">
									<input type="checkbox" id="translateToggle" name="translateToggle" class="custom-switch-input" <?php if ($ticket->translate) echo 'Checked'; ?>>
									<span class="custom-switch-indicator"></span>
									<span class="custom-switch-description"></span>
								</label>
							</div>
						</div>
						<div id="isTranslate" class="col-lg-12 col-md-12" style="display:none;">
							<div class="form-group">
								<label class="form-label">Translation</label>
								<div class="input-group">
									<textarea id="translate" name="translate" class="form-control">{{$ticket->translate}}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Organization</label>
								<select id="organization" name="organization" class="form-control">
									<option value="{{$ticket->org_id}}" selected="selected">
										{{ App\Organization::where('id', $ticket->org_id)->value('org_name') }}
									</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Ticketholder (Client)</label>
								<select id="users" name="user" class="form-control">
									<option value="{{$ticket->user}}" selected="selected">
										{{ App\User::where('id', $ticket->user)->value('first_name') }}
									</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Assigned User (Internal)</label>
								<select id="personnel" name="personnel" class="form-control">
									<option value="{{$ticket->personnel}}" selected="selected">
										{{ App\User::where('id', $ticket->personnel)->value('first_name') }}
									</option>
								</select>
							</div>
						</div>
					</div>
					@else
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<div class="input-group">
									<h3 style="color:#705EC8;">#{{$ticket->id}} | {{$ticket->name}}</h3>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label class="form-label"><b>Description</b></label>
								<div class="input-group">
									@if($ticket->description)
									<span>{!!$ticket->description!!}</span>
									@else
									<span> - </span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label class="form-label"><b>Translation</b></label>
								<div class="input-group">
									@if($ticket->translate)
									<span>{!!$ticket->translate!!}</span>
									@else
									<span> - </span>
									@endif
								</div>
							</div>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Organization</label>
								<select name="organization" class="form-control" readonly>
									<option value="{{$ticket->org_id}}" selected="selected">
										{{ App\Organization::where('id', $ticket->org_id)->value('org_name') }}
									</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">User</label>
								<select name="user" class="form-control" readonly>
									<option value="{{$ticket->user}}" selected="selected">
										{{ App\User::where('id', $ticket->user)->value('first_name') }}
									</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Personnel</label>
								<select name="personnel" class="form-control" readonly>
									<option value="{{$ticket->personnel}}" selected="selected">
										{{ App\User::where('id', $ticket->personnel)->value('first_name') }}
									</option>
								</select>
							</div>
						</div>
					</div>
					@endif
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Status</label>
								<select name="status" class="form-control">
									@foreach($data['status'] as $status)
									<option value="{{$status->id}}" <?php if ($ticket->status_id == $status->id) {
																		echo 'selected';
																	}
																	?>>
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
									<option value="4" <?php if ($ticket->priority == 4) {
															echo 'selected';
														} ?>>Low</option>
									<option value="1" <?php if ($ticket->priority == 1) {
															echo 'selected';
														} ?>>Normal</option>
									<option value="2" <?php if ($ticket->priority == 2) {
															echo 'selected';
														} ?>>High</option>
									<option value="3" <?php if ($ticket->priority == 3) {
															echo 'selected';
														} ?>>Very High</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Category</label>
								<select name="category" class="form-control">
									@foreach($data['category'] as $category)
									<option value="{{$category->id}}" <?php if ($ticket->category == $category->id) {
																			echo 'selected';
																		}
																		?>>{{$category->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Due Date</label>
								<input class="form-control" type="date" name="due_date" value="{{$ticket->due_date}}">
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Transport Price</label>
								<input class="form-control" type="number" name="transport_price" value="{{$ticket->transport_price}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3">
							<h4>Effort</h4>
						</div>
					</div>
					<div class="row">
						@if(auth()->user()->role_id ==1)
						<div class="col-lg-1 col-md-1">
							<div class="form-group">
								<label class="form-label">Good Will</label>
								<select name="good_will" class="form-control">
									@foreach($data['goodWill'] as $goodWill)
									<option value="{{$goodWill->frequency}}" <?php if ($ticket->good_will == $goodWill->frequency) {
																					echo 'selected';
																				}
																				?>>{{$goodWill->frequency}}%</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Coding</label>
								<div class="input-group">
									<input class="form-control" type="number" name="coding_hours" value="<?php if (count($ticket->coding_time)) echo $ticket->coding_time[0]; ?>">
									<div class="input-group-prepend">
										<div class="input-group-text">hours</div>
									</div>
									<input class="form-control" type="number" name="coding_mints" value="<?php if (isset($ticket->coding_time[1])) echo $ticket->coding_time[1]; ?>">
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
									<input class="form-control" type="number" name="consulting_hours" value="<?php if (count($ticket->consulting_time)) echo $ticket->consulting_time[0]; ?>">
									<div class="input-group-prepend">
										<div class="input-group-text">hours</div>
									</div>
									<input class="form-control" type="number" name="consulting_mints" value="<?php if (isset($ticket->consulting_time[1])) echo $ticket->consulting_time[1]; ?>">
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
									<input class="form-control" type="number" name="testing_hours" value="<?php if (count($ticket->testing_time)) echo $ticket->testing_time[0]; ?>">
									<div class="input-group-prepend">
										<div class="input-group-text">hours</div>
									</div>
									<input class="form-control" type="number" name="testing_mints" value="<?php if (isset($ticket->testing_time[1])) echo $ticket->testing_time[1]; ?>">
									<div class="input-group-prepend">
										<div class="input-group-text">minutes</div>
									</div>
								</div>
							</div>
						</div>
						@endif
						<div class="col-lg-1 col-md-1">
							<div class="form-group">
								<label class="form-label">Total Time</label>
								<input class="form-control" type="text" name="total_time" value="{{$ticket->total_time}}" readonly>
							</div>
						</div>
					</div>
					<div id="attachmentResponse">
					</div>
				</form>
				<div class="row">
					<div class="col-lg-3 col-md-3">
						<h4>Attachments</h4>
					</div>
				</div>
				<div class="row">
					@if($ticket['attachment'])
					@foreach($ticket['attachment'] as $attachment)
					<div class="col-lg-3 col-md-3">
						<div class="alert alert-success" role="alert">
							<button type="button" class="close deleteAttachment" data-id="{{$attachment->id}}">×</button>
							<a href="{{asset('/storage/tickets-uploads').'/'.$attachment->attachment}}">
								<i class="fa fa-file mr-2" aria-hidden="true"></i><span class="white">{{$attachment->attachment}}</span>
							</a>
						</div>
					</div>
					@endforeach
					@endif
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
						<button type="submit" id="updateTicketButton" class="btn btn-primary mt-4 mb-0 float-right">Submit</button>
						<a href="{{url('/tickets')}}" class="btn btn-danger mt-4 mb-0 mr-4 float-right">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Discussion</h3>
			</div>
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
				<form id="discussionForm" method="post">
					@csrf
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<div class="input-group">
									<textarea id="discussion" name="discussion" class="form-control"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<button type="submit" id="sendDiscussion" class="btn btn-warning mt-4 mb-0 float-right"><i class="fe fe-edit"></i>Response</button>
							@if(auth()->user()->org_id == 1||auth()->user()->org_id == 8)
							<button type="submit" id="sendPrivateDiscussion" class="btn btn-primary mr-4 mt-4 mb-0 float-right"><i class="fe fe-lock"></i>Private</button>
							@endif
						</div>
					</div>
				</form>
				@foreach($ticket['discussion'] as $discussion)
				<div class="row">
					<div class="col-sm-6 col-md-6">
						@if($discussion['is_private'] && (auth()->user()->org_id == 1||auth()->user()->org_id == 8))
						<div class="alert alert-light-{{($discussion['is_private'])?'private':'primary'}}">
							<strong class="pr-4">{{$discussion['UserName']}}</strong>
							@if(auth()->user()->org_id == 1||auth()->user()->org_id == 8)
							<button type="button" class="btn btn-private lockToggle" message-id="{{$discussion->id}}" data-id="0">
								<i class="fe fe-lock"></i>Private</button>@endif
							<strong class="float-right">
								{{ \Carbon\Carbon::parse($discussion['created_at'])->format('d.m.Y [ h:i:s ]')}}</strong>
							<hr class="message-inner-separator">
							<p>{!!$discussion->message!!}
								@if (strpos($discussion->message, "
							<div>") !== false) {
								echo "</div>";
							@endif
							</p>
						</div>
						@endif
						@if(!$discussion['is_private'])
						<div class="alert alert-light-{{($discussion['is_private'])?'private':'primary'}}">
							<strong class="pr-4">{{$discussion['UserName']}}</strong>
							@if(auth()->user()->org_id == 1||auth()->user()->org_id == 8)
							<button type="button" class="btn btn-primary lockToggle" message-id="{{$discussion->id}}" data-id="1">
								<i class="fe fe-unlock"></i>Private</button>
							@endif
							<strong class="float-right">
								{{ \Carbon\Carbon::parse($discussion['created_at'])->format('d.m.Y [ h:i:s ]')}}</strong>
							<hr class="message-inner-separator">
							<p>{!!$discussion->message!!}
								@if (strpos($discussion->message, "
							<div>") !== false) {
								echo "</div>";
							@endif
							</p>
						</div>
						@endif
					</div>
				</div>
				@endforeach
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
	$('#discussion').trumbowyg({
		autogrow: true
	});
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
		var isTranslate = $("#translateToggle").is(":checked");
		if (isTranslate) {
			$('#isTranslate').css('display', 'block');
		} else
			$('#isTranslate').css('display', 'none');
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
		$('#users').select2({
			ajax: {
				url: '/getOrganizationUsersRawData/' + <?php echo $ticket->org_id; ?> + '?returnType=raw',
				processResults: function(data, page) {
					return {
						results: data
					};
				}
			}
		});
	});
	// $('#organization').trigger('change');
	$('#organization').change();
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
	$('#updateTicketButton').on('click', function() {
		$('#updateTicket').submit();
	})
	$(document).on('click', '.deleteAttachment', function(e) {
		var id = $(this).attr('data-id');
		$.ajax({
			type: "GET",
			url: '/removeAttachment/' + id,
			success: function(response) {
				if (!response.error) {
					location.reload();
				} else {
					toastr.error(response.error, 'Error');
				}
			}
		});
	});
	$('#sendDiscussion').on('click', function(e) {
		$('#discussionForm').on('submit', function(e) {
			e.preventDefault();
			var form = $('#discussionForm');
			var url = '/create-discussion/' + <?php echo $ticket->id; ?> + '?private=0';
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				success: function(response) {
					if (!response.error) {
						window.location.reload();
					}
				}
			});
		});
	});
	$('#sendPrivateDiscussion').on('click', function(e) {
		$('#discussionForm').on('submit', function(e) {
			e.preventDefault();
			var form = $('#discussionForm');
			var url = '/create-discussion/' + <?php echo $ticket->id; ?> + '?private=1';
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				success: function(response) {
					if (!response.error) {
						window.location.reload();
					}
				}
			});
		});
	});
	$('.lockToggle').on('click', function(e) {
		var status = $(this).attr('data-id');
		var messageId = $(this).attr('message-id');
		var url = '/changeMessageStatus/' + messageId + '?private=' + status;
		$.ajax({
			type: "GET",
			url: url,
			success: function(response) {
				if (!response.error) {
					window.location.reload();
				}
			}
		});
	});
</script>
@endsection