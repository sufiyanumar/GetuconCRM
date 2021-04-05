@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link rel="stylesheet" href="{{asset('drop-zone/dropzone.css')}}">
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Organization</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/tickets')}}"><i class="fe fe-file-text mr-2 fs-14"></i>Tickets</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">{{$ticket->name}}</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{url('/update-ticket').'/'.$ticket->id}}" class="btn btn-warning"><i class="fe fe-edit mr-1"></i> Edit </a>
			<a href="#" data-toggle="modal" data-target="#deleteTicketModal" class="btn btn-danger"><i class="fe fe-trash mr-1"></i> Delete </a>
		</div>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Ticket Information</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group">
							<label class="form-label">Ticket Name</label>
							<div class="input-group">
								<span>{{$ticket->name}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group">
							<label class="form-label">Description</label>
							<div class="input-group">
								@if($ticket->description)
								<span>{!!$ticket->description!!}</span>
								@else
								<span> - </span>
								@endif
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
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
				<div class="row">
					<div class="col-lg-4 col-md-4">
						<div class="form-group">
							<label class="form-label">Organization</label>
							<div class="input-group">
								<span>{{$ticket->OrganizationName}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4">
						<div class="form-group">
							<label class="form-label">User</label>
							<div class="input-group">
								<span>{{$ticket->UserName}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4">
						<div class="form-group">
							<label class="form-label">Personnel</label>
							<div class="input-group">
								<span>{{$ticket->PersonnelName}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					@if($ticket['attachment'])
					@foreach($ticket['attachment'] as $attachment)
					<div class="col-lg-3 col-md-3">
						<div class="alert alert-success" role="alert">
							<button type="button" class="close deleteAttachment" data-id="{{$attachment->id}}">×</button>
							<a href="{{asset('/storage/tickets-uploads/uploads').'/'.$attachment->attachment}}" target="_blank">
								<i class="fa fa-file mr-2" aria-hidden="true"></i><span class="white">{{$attachment->attachment}}</span>
							</a>
						</div>
					</div>
					@endforeach
					@endif
				</div>
				<div class="row">
					<div class="col-md-12">
						<form class="dropzone" id="ticketAttachments"> @csrf</form>
					</div>
				</div>
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

<script src="{{asset('drop-zone/dropzone.js')}}"></script>
<script>
	Dropzone.autoDiscover = false;
	$('#ticketAttachments').dropzone({
		maxFiles: 5,
		parallelUploads: 10,
		uploadMultiple: false,
		addRemoveLinks: true,
		acceptedFiles: 'image/jpeg,image/png,image/jpg,.pdf,.csv',
		url: '/attachFiles?type=single',
		success: function(file, response) {
			if (response.error)
				toastr.error(response.error, 'Error');
			else {
				$.ajax({
					type: "get",
					url: '/addAttachment/' + <?php echo $ticket->id; ?> + '/?attachment=' + response.data.link,
					success: function(response) {
						if (!response.error) {
							window.location.reload();
						}
					}
				});
				toastr.success(response.success, 'Success');
			}
		}
	});
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
</script>
@endsection