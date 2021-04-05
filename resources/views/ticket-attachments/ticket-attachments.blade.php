@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Ticket Attachments</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fe fe-layout mr-2 fs-14"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Ticket Attachments</a></li>
		</ol>
	</div>
	<!-- <div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{url('/add-ticket')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Add Ticket </a>
		</div>
	</div> -->
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
		<!--div-->
		<div class="card">
			@if(Session::get('success'))
			<div class="alert alert-success" role="alert">
				<button type="button" class="close">×</button>
				<i class="fa fa-file mr-2" aria-hidden="true"></i><span class="white">{{ session()->get('success') }}</span>
			</div>
			@endif
			<div class="card-header">
				<div class="card-title">Tickets Data</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-wrap" id="ticketAttachmentData" style="width:100%">
						<thead>
							<tr>
								<th style="width:8%" class="border-bottom-0">Ticket</th>
								<th style="width:20%" class="border-bottom-0">Organization</th>
								<th style="width:20%" class="border-bottom-0">Installer</th>
								<th style="width:20%" class="border-bottom-0">File</th>
								<th style="width:20%" class="border-bottom-0">File Size</th>
								<th style="width:20%" class="border-bottom-0">Date</th>
								<th style="width:10%" class="border-bottom-0">Action</th>
							</tr>
							<tr>
								<th style="width:8%" class="border-bottom-0">Ticket</th>
								<th style="width:20%" class="border-bottom-0">Organization</th>
								<th style="width:20%" class="border-bottom-0">Installer</th>
								<th style="width:20%" class="border-bottom-0">File</th>
								<th style="width:20%" class="border-bottom-0">File Size</th>
								<th style="width:20%" class="border-bottom-0">Date</th>
								<th style="width:10%" class="border-bottom-0">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
<div class="modal fade" id="deleteTicketModal" tabindex="-1" role="dialog" aria-labelledby="deleteTicketModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Ticket</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deleteTicket">
					@csrf
					<input type="hidden" name="deleteTicketId" id="deleteTicketId">
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
<!-- INTERNAL Data tables -->
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

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script>
	function ticketAttachmentData() {
		$('#ticketAttachmentData thead tr:eq(1) th').each(function(i) {
			var title = $(this).text();
			if (title != 'File Size' && title != 'Date' && title != 'Action') {
				$(this).html('<input type="text" placeholder="Search"  class="form-control ' + title + '" />');
				$('input', this).on('keyup change', function() {
					if ($('#ticketAttachmentData').DataTable().column(i).search() !== this.value) {
						$('#ticketAttachmentData').DataTable()
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			} else {
				$(this).html('');
			}
		});
		var dt = $('#ticketAttachmentData').DataTable({
			"processing": true,
			"autoWidth": false,
			"serverSide": true,
			"ajax": {
				url: '/getTicketAttachments',
				type: "GET",
			},
			select: true,
			"columns": [{
					"data": "ticket_id",
					"visible": true,
					"orderable": false,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "organization",
					"visible": true,
					"orderable": true,
					"searchable": false,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "installer",
					"visible": true,
					"orderable": true,
					"searchable": false,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "attachment",
					"visible": true,
					"orderable": true,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "size",
					"visible": true,
					"orderable": true,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "ParsedCreatedAt",
					"visible": true,
					"orderable": true,
					"searchable": false,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "actions",
					"visible": true,
					render: function(data, type, row) {
						if (data) {
							return data;
						} else {
							return '-';
						}
					}
				},
			],
			"iDisplayLength": 10
		});
		dt.on('click', 'tbody tr td:not(:last-child)', function(e) {
			var data = dt.row($(this).parents('tr')).data();
			window.location.href = '/ticket-attachment/' + data['ticket_id'];
		});
		dt.on('click', 'td .deleteTicket', function(e) {
			var id = $(this).attr('data-id');
			$('#deleteTicketModal').modal('show');
			$.ajax({
				type: "GET",
				url: 'getOrganization/' + id,
				success: function(response) {
					if (!response.error) {
						$('#deleteTicketId').val(response.id);
					}
				}
			});
		});
	};

	function resetDataTable() {
		$('#ticketsData').DataTable().clear();
		$('#ticketsData').DataTable().destroy();
	}

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
					$('#message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response + '</div>');
					$("#deleteTicket")[0].reset();
					$('#deleteTicketModal').modal('hide');
					resetDataTable();
					ticketsData();
				}
			}
		});
	});
	$(document).ready(function() {
		ticketAttachmentData();
	});
</script>
@endsection