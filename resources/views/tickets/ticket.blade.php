@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('text-editor/trumbowyg.min.css')}}">
<style>
	.vl {
		border-right: 2px solid #ebecf1;
		height: 82px
	}

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

	.pointer {
		cursor: pointer;
	}

	hr {
		margin-top: 2rem;
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
		<h4 class="page-title mb-0">Ticket</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/tickets')}}"><i class="fe fe-file-text mr-2 fs-14"></i>Tickets</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">{{$ticket->name}}</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{url('/tickets')}}" class="btn btn-danger"><i class="fa fa-backward mr-1"></i> Back </a>
			@if(in_array('UPDATE_TICKET', auth()->user()->Permissions))
			<a href="{{url('/update-ticket').'/'.$ticket->id}}" class="btn btn-warning"><i class="fe fe-edit mr-1"></i> Edit </a>
			@endif
			@if(in_array('SEND_UPDATE_TICKET', auth()->user()->Permissions))
			<a href="{{url('/send-update').'/'.$ticket->id}}" class="btn btn-info"><i class="fe fe-check mr-1"></i> Send Update </a>
			@endif
			@if(in_array('DELETE_TICKET', auth()->user()->Permissions))
			<a href="#" data-toggle="modal" data-target="#deleteTicketModal" class="btn btn-danger"><i class="fe fe-trash mr-1"></i> Delete </a>
			@endif
		</div>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row ">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Ticket Information</h3>
			</div>
			<div class="card-body" style="padding-top: 5px;">
				<div class="row pt-5">
					<div class="col-lg-9 col-md-9 border pt-5 bg-theme text-white align-self-center">
						<div class="form-group">
							<div class="input-group pt-2">
								<h3>#{{$ticket->id}} | {{$ticket->name}}</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 border bg-light" style="padding-top: 9px;">
						<div class="form-group" style="margin-bottom: -2px;">
							<label class="form-label" style="font-weight: normal;">Ticket created from:
								@if($ticket->created_at)
								<span>{{$ticket->UserName}} {{$ticket->Surname}}</span>
								@else
								<span> - </span>
								@endif
							</label>
							<label class="form-label" style="font-weight: normal;">Ticket created on&nbsp;&nbsp;&nbsp;&nbsp;:
								@if($ticket->created_at)
								<span>{{$ticket->created_at}}</span>
								@else
								<span> - </span>
								@endif
							</label>
							<label class="form-label" style="font-weight: normal;">Last updateed on&nbsp;&nbsp;&nbsp;&nbsp;:
								@if($ticket['lastEdit'])
								<span>{{$ticket['lastEdit']->created_at}}</span>
								@else
								<span> - </span>
								@endif
							</label>
						</div>
					</div>
				</div>
				<div class="row pt-5 border">
					<div class="col-lg-12 col-md-12 ">
						<div class="form-group">
							<label class="form-label">Description</label>
							<div class="input-group">
								@if($ticket->description)
								<span>{!!$ticket->description!!}</span>
								@if (strpos($ticket->description, "<div>") !== false) {
									echo "</div>";
								@endif
								@else
								<span> - </span>
								@endif
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="form-group">
							<label class="form-label">Translation</label>
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

				<div class="row pt-5">
					<div class="col-lg-4 col-md-4 border pt-5 bg-theme text-white">
						<div class="form-group">
							<label class="form-label">Organization</label>
							<div class="input-group">
								<span>{{$ticket->OrganizationName}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 border pt-5 bg-light">
						<div class="form-group">
							<label class="form-label">Ticketholder (Client)</label>
							<div class="input-group">
								<span>{{$ticket->UserName}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 border pt-5 bg-light">
						<div class="form-group">
							<label class="form-label">Assigned to (Internal)</label>
							<div class="input-group">
								<span>{{$ticket->PersonnelName}}</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row pt-5">
					<div class="col-lg-4 col-md-4 border pt-5 bg-dark text-white">
						<div class="form-group">
							<label class="form-label">Status</label>
							<div class="input-group">
								<span>{{$ticket->StatusName}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 border pt-5">
						<div class="form-group">
							<label class="form-label">Priority</label>
							<div class="input-group">
								<span>{{$ticket->PriorityName}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 border pt-5">
						<div class="form-group">
							<label class="form-label">Category</label>
							<div class="input-group">
								<span>{{$ticket->CategoryName}}</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row pt-5">
					<div class="col-lg-4 col-md-4 border pt-5">
						<div class="form-group">
							<label class="form-label">Due Date</label>
							<div class="input-group">
								<span>{{$ticket->due_date}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 border pt-5">
						<div class="form-group">
							<label class="form-label">Transport Price</label>
							<div class="input-group">
								<span>{{$ticket->transport_price}}</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row pt-5">
					<div class="col-lg-3 col-md-3">
						<h4>Effort</h4>
					</div>
				</div>
				<div class="row pt-2">
					@if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
					<div class="col-lg-3 col-md-3 border pt-5 bg-light">
						<div class="form-group">
							<label class="form-label">Good Will</label>
							<span>{{$ticket->good_will}}%</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 border pt-5">
						<div class="form-group">
							<label class="form-label">Coding</label>
							<span>{{$ticket->coding}}</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 border pt-5 bg-light">
						<div class="form-group">
							<label class="form-label">Consulting</label>
							<span>{{$ticket->consulting}}</span>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 border pt-5">
						<div class="form-group">
							<label class="form-label">Testing</label>
							<span>{{$ticket->testing}}</span>
						</div>
					</div>
					@endif
					<div class="col-lg-3 col-md-3 border pt-5 bg-light">
						<div class="form-group">
							<label class="form-label">Total Time</label>
							<span>{{$ticket->total_time}}</span>
						</div>
					</div>
				</div>
				@if($ticket['attachment'])
				<?php $attachment_count = count($ticket['attachment']); ?>
				<div class="row pt-2 border">
					<div class="col-xl-6 col-lg-6 col-md-6">
						<div class="form-group">
							<div class="form-label">Attached Files (<?php echo $attachment_count; ?>)</div>
							<label class="custom-switch">
								<input type="checkbox" id="attachmentToggle" name="attachmentToggle" class="custom-switch-input" <?php
																																	if ($attachment_count > 0) {
																																		echo 'Checked';
																																	} ?>>
								<span class="custom-switch-indicator"></span>
								<span class="custom-switch-description"></span>
							</label>



						</div>
					</div>
				</div>
				<div class="row border" id="attachments" <?php
															if (count($ticket['attachment']) == 0) { ?> style="display:none;" <?php } ?>>
					<div class="table-responsive">
						<table class="table table-bordered text-wrap" id="" style="width:100%">
							<thead>
								<tr>
									<th style="width:5%">ID</th>
									<th style="width:20%">File Name</th>
									<th style="width:20%">File Size (MB)</th>
									<th style="width:20%">Uploaded From</th>
									<th style="width:20%">Uploaded Date</th>
									<th style="width:25%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($ticket['attachment'] as $attachment)
								<tr>
									<td>{{$attachment->id}}</td>
									<td>{{$attachment->attachment}}</td>
									<td>{{round($attachment->size * 0.000001, 2)}} MB</td>
									<td>{{$attachment->UserName}} {{$attachment->SurName}}</td>
									<td>{{$attachment->ParsedCreatedAt}}</td>
									@if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 3 || auth()->user()->role_id == 4)<td><i class="btn btn-danger deleteAttachment fa fa-trash" data-id="{{$attachment->id}}"></i> &nbsp;
										<a href="{{asset('/storage/uploadsnew/attach').'/'.$attachment->attachment}}" class="btn btn-primary" target="_blank" style="padding: 2px; padding-left: 12px; padding-right: 12px;"><i class="fa fa-eye"></i></a>
									</td>
									@endif
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<!-- @foreach($ticket['attachment'] as $attachment) -->
					<!-- <div class="col-lg-3 col-md-3">
						<div class="alert alert-success" role="alert">
							@if(auth()->user()->role_id ==1)<button type="button" class="close deleteAttachment" data-id="{{$attachment->id}}">×</button>@endif
							<a href="{{asset('/storage/tickets-uploads').'/'.$attachment->attachment}}">
								<i class="fa fa-file mr-2" aria-hidden="true"></i><span class="white">{{$attachment->attachment}}</span>
							</a>
						</div>
					</div> -->
					<!-- @endforeach -->
				</div>
				@endif
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
<div class="modal fade" id="deleteTicketModal" tabindex="-1" role="dialog" aria-labelledby="deleteTicketModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Organization</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deleteTicket">
					@csrf
					<input type="hidden" name="deleteTicketId" id="deleteTicketId" value="{{$ticket->id}}">
					<p>Are you sure you want to delete this Ticket?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger">Delete</button>
			</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('js')
<!--INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{asset('text-editor/trumbowyg.min.js')}}"></script>
<script>
	$('#attachmentToggle').on('change', function() {
		var isAttachment = $("#attachmentToggle").is(":checked");
		if (isAttachment) {
			$('#attachments').css('display', 'block');
		} else
			$('#attachments').css('display', 'none');

	});
	$('#discussion').trumbowyg();
	$('#deleteTicket').on('submit', function(e) {
		e.preventDefault();
		var form = $('#deleteTicket');
		var id = $('#deleteTicketId').val();
		var url = '/delete-ticket/' + id;
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			success: function(response) {
				if (!response.error) {
					$("#deleteTicket")[0].reset();
					$('#deleteTicketModal').modal('hide');
					window.location.href = "/tickets";
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
	$('.deleteAttachment').on('click', function(e) {
		var id = $(this).attr('data-id');
		var url = '/deleteAttachment/' + id;
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