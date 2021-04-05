@extends('layouts.master') 
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" /> 
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
	input#Organization {
		width: 130px !important;
	}

	input#Personnel {
		width: 100px !important;
	}

	input#Category {
		width: 96px !important;
	}

	input#Subject {
		width: 437px !important;
	}

	input#Priority {
		width: 85px !important;
	}

	.btn-status {
		/* color: #fff !important;
		background-color: #fb1c52;
		border-color: #fb1c52; */
		box-shadow: 0 0px 10px -5px rgb(251 28 82 / 50%);
	}
</style>
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Tickets</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fe fe-layout mr-2 fs-14"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Tickets</a></li>
		</ol>
		<div class="">
		@if(in_array('CREATE_TICKET', auth()->user()->Permissions))
		<div class="page-rightheader" style="float: right;">
			<div class="btn btn-list">
				<a href="{{url('/add-ticket')}}" class="btn btn-info">
					<i class="fa fa-plus-circle"></i> New Ticket </a>
			</div>
		</div>
		<div style="clear: both;"></div>
		@endif

			<a class="btn btn-status statusFilter statusButtonCss" data-id="all" style="background-color: #7966AD; color: #FFFFFF;">
				<span style="display: block; font-size: 30px;" class="fa fa-refresh" aria-hidden="true"></span>
				Refresh
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="1" style="background-color: #7DAA50; color: #FFFFFF;">
				<span style="display: block;">{{$data['totalOpenTickets']}}</span>
				Opened
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="2" style="background-color: #E0E0E0; color: #1A1630;">
				<span style="display: block;">{{$data['transferedTickets']}}</span>
				Transferred
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="3" style="background-color: #6B6B6B; color: #FFFFFF;">
				<span style="display: block;">{{$data['inProgressTickets']}}</span>
				In Progress
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="4" style="background-color: #BA3129; color: #FFFFFF;">
				<span style="display: block;">{{$data['answeredTickets']}}</span>
				Answered
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="5" style="background-color: #AF2823; color: #FFFFFF;">
				<span style="display: block;">{{$data['queryTickets']}}</span>
				Query
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="6" style="background-color: #3991CE; color: #FFFFFF;">
				<span style="display: block;">{{$data['doneTickets']}}</span>
				Done
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="7" style="background-color: #17679B; color: #FFFFFF;">
				<span style="display: block;">{{$data['invoicedTickets']}}</span>
				Invoiced
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="8" style="background-color: #E05E02; color: #FFFFFF;">
				<span style="display: block;">{{$data['onHoldTickets']}}</span>
				On Hold
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="9" style="background-color: #7966AD; color: #FFFFFF;">
				<span style="display: block;">{{$data['closedTickets']}}</span>
				Closed
			</a>
			<a class="btn btn-status statusFilter statusButtonCss" data-id="all" style="background-color: #96A9B5; color: #FFFFFF;">
				<span style="display: block;">{{$data['totalTickets']}}</span>
				All Tickets
			</a>
		</div>
	</div>



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
				<div class="card-title">Tickets List</div>
				@if(in_array('CREATE_TICKET', auth()->user()->Permissions))
				<div class="page-rightheader" style="float: right;">
					<div class="btn btn-list">
						<a href="{{url('/add-ticket')}}" class="btn btn-info">
						<i class="fa fa-plus-circle"></i> New Ticket </a>
					</div>
				</div>
				<div style="clear: both;"></div>
				@endif
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-wrap" id="ticketsData" width="100%">
						<thead>
							<tr>
								<th class="border-bottom-0">No#</th>
								<th class="border-bottom-0">Organization</th>
								<th class="border-bottom-0">Ticketholder</th>
								<th class="border-bottom-0">Assigned to</th>
								<th class="wd-15p border-bottom-0">Status</th>
								<th class="wd-15p border-bottom-0">Category</th>
								<th class="wd-15p border-bottom-0">Subject</th>
								<th class="wd-15p border-bottom-0">Priority</th>
								<th class="wd-20p border-bottom-0">Ticket Date</th>
								<th class="wd-20p border-bottom-0" style="width:60px;">Due Date</th>
								<th class="wd-10p border-bottom-0" style="width: 10%;">Action</th>
							</tr>
							<tr>
								<th class="border-bottom-0">No#</th>
								<th class="border-bottom-0">Organization</th>
								<th class="border-bottom-0">Ticketholder</th>
								<th class="border-bottom-0">Assigned to</th>
								<th class="status wd-15p border-bottom-0">Status</th>
								<th class="wd-15p border-bottom-0">Category</th>
								<th class="wd-15p border-bottom-0">Subject</th>
								<th class="wd-15p border-bottom-0">Priority</th>
								<th class="wd-20p border-bottom-0" style="width:60px;">Ticket Date</th>
								<th class="wd-20p border-bottom-0" style="width:60px;">Due Date</th>
								<th class="wd-10p border-bottom-0" style="width: 10%;">Action</th>
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
	function ticketsData(status) {
		var dt = $('#ticketsData').DataTable({
			initComplete: function() {
				this.api().columns('.status').every(function() {
					var column = this;
					var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo($(column.header()).empty())
						.on('change', function() {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});
					var options = 9;
					for (d = 1; d <= options; d++) {
						if (d == 1)
							text = 'Opened';
						if (d == 2)
							text = 'Transferred';
						if (d == 3)
							text = 'In progress';
						if (d == 4)
							text = 'Answered';
						if (d == 5)
							text = 'Query';
						if (d == 6)
							text = 'Done';
						if (d == 7)
							text = 'Invoiced';
						if (d == 8)
							text = 'On Hold';
						if (d == 9)
							text = 'Closed';
						select.append('<option value="' + d + '">' + text + '</option>')
					}
				});
			},
			"processing": true,
			"serverSide": true,
			"stateSave": true,
			"destroy": true,
			"paging": true,
			"ajax": {
				url: '/getTickets?status=' + status,
				type: "GET",
			},
			select: true,
			"columns": [{
					"data": "id",
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
					"data": "org_id",
					"visible": true,
					"orderable": false,
					"searchable": true,
					render: function(data, type, row) {
						if (data)
							return row['OrganizationName'];
						else
							return '-';
					}
				},
				{
					"data": "user",
					"visible": true,
					"orderable": false,
					"searchable": true,
					render: function(data, type, row) {
						if (data)
							return row['UserName'] + " " + row['SurName'];
						else
							return '-';
					}
				},
				{
					"data": "personnel",
					"visible": true,
					"orderable": false,
					"searchable": true,
					render: function(data, type, row) {
						if (data)
							return row['PersonnelName'] + " " + row['PersonnelSurName'];
						else
							return '-';
					}
				},
				{
					"data": "status_id",
					"visible": true,
					"orderable": false,
					"searchable": true,
					render: function(data, type, row) {
						if (data)
							return row['StatusName'];
						else
							return '-';
					}
				},
				{
					"data": "category",
					"visible": true,
					"orderable": false,
					"searchable": true,
					render: function(data, type, row) {
						if (data)
							return row['CategoryName'];
						else
							return '-';
					}
				},
				{
					"data": "name",
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
					"data": "priority",
					"visible": true,
					"orderable": false,
					"searchable": true,
					render: function(data, type, row) {
						if (data)
							return row['PriorityName'];
						else
							return '-';
					}
				},
				{
					"data": "ParsedCreatedAt",
					"visible": true,
					"orderable": false,
					"searchable": false,
					render: function(data, type, row) {
						if (data)
							return data;
						else
							return '-';
					}
				},
				{
					"data": "ParsedDueDate",
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
					"data": "actions",
					"visible": true,
					"orderable": false,
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
			if (data)
				window.location.href = '/update-ticket/' + data['id'];
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
	$('.statusFilter').on('click', function() {
		var status = $(this).attr('data-id');
		resetDataTable();
		ticketsData(status);

	});
	$(document).ready(function() {
		$('#ticketsData thead tr:eq(1) th').each(function(i) {
			var title = $(this).text();
			var width;
			if (title == 'No#')
				width = '51px';
			if (title == 'Organization')
				width = '130px';
			if (title == 'Personnel')
				width = '100px';
			if (title == 'Category')
				width = '96px';
			if (title == 'Subject')
				width = '437px';
			if (title == 'Priority')
				width = '85px';
			if (title != 'Ticket Date' && title != 'Due Date' && title != 'Action') {
				$(this).html('<input type="text" placeholder="Search"  class="form-control ' + title + '" style="width: ' + width + '"/>');
				$('input', this).on('keyup change', function() {
					if ($('#ticketsData').DataTable().column(i).search() !== this.value) {
						$('#ticketsData').DataTable()
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			} else {
				$(this).html('');
			}
		});
		ticketsData('all');
	});
</script>
@endsection