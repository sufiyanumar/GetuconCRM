@extends('layouts.master') 
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

<style>
	tr {
		cursor: pointer;
	}

	.redClass {
		background: #EF5858;
		color: white;
	}
</style>

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Organizations</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fe fe-layout mr-2 fs-14"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Organizations</a></li>
		</ol>
	</div>
	@if(in_array('CREATE_ORGANIZATION', auth()->user()->Permissions))
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{url('/add-organization')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Add Organization </a>
		</div>
	</div>
	@endif
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">
		<!--div-->
		<div class="card">
			<div id="message">
			</div>
			<div class="card-header">
				<div class="card-title">Organizations Data</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="organizationsData" width="100%">
						<thead>
							<tr>
								<th style="width:10%" class="border-bottom-0"></th>
								<th style="width:20%" class="rating border-bottom-0">Rating</th>
								<th style="width:50%" class="border-bottom-0">Name</th>
								<th style="width:50%" class="status border-bottom-0">Status</th>
								<th style="width:10%" class="border-bottom-0">Action</th>
							</tr>
							<tr>
								<th style="width:20%" class="border-bottom-0"></th>
								<th style="width:20%" class="rating border-bottom-0">Rating</th>
								<th style="width:5%" class="border-bottom-0">Name</th>
								<th style="width:5%" class="status border-bottom-0">Status</th>
								<th style="width:20%" class="border-bottom-0">Action</th>
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
<div class="modal fade" id="deleteOrganizationModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrganizationModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Organization</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deleteOrganization">
					@csrf
					<input type="hidden" name="deleteOrganizationId" id="deleteOrganizationId">
					<p>Are you sure you want to delete this organization?</p>
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
	function organizationsData() {
		var dt = $('#organizationsData').DataTable({
			initComplete: function() {
				this.api().columns('.rating').every(function() {
					var column = this;
					var select = $('<select class="form-control"><option value=""></option><option value="Good Client">Good Client</option><option value="Normal Client">Normal Client</option><option value="Blacklist Client">Blacklist Client</option></select>')
						.appendTo($(column.header()).empty())
						.on('change', function() {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});
				});
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

					column.data().unique().sort().each(function(d, j) {
						if (d == 1)
							value = 'Active';
						else
							value = 'Inactive';
						select.append('<option value="' + value + '">' + value + '</option>')
					});
				});
			},
			"processing": false,
			"serverSide": false,
			"ajax": {
				url: '/getOrganizations',
				type: "GET",
			},
			select: true,
			"createdRow": function(row, data, dataIndex) {
				if (data['is_active'] == 0) {
					$(row).addClass('redClass');
				}
			},
			"columns": [{
					"data": "profile_picture",
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
					"data": "rating_flag",
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
					"data": "org_name",
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
					"data": "is_active",
					"visible": true,
					"orderable": true,
					render: function(data, type, row) {
						if (data)
							return 'Active';
						else
							return 'Inactive';
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
			window.location.href = '/organization/' + data['id'];
		});
		dt.on('click', 'td .deleteOrganization', function(e) {
			var id = $(this).attr('data-id');
			$('#deleteOrganizationModal').modal('show');
			$.ajax({
				type: "GET",
				url: 'getOrganization/' + id,
				success: function(response) {
					if (!response.error) {
						$('#deleteOrganizationId').val(response.id);
					}
				}
			});
		});
		dt.on('click', 'td .updateStatus', function(e) {
			var organzationId = $(this).attr('data-id');
			var status = $(this).attr('data-status');
			$.ajax({
				type: "GET",
				url: '/updateOrganizationStatus/' + organzationId + '?status=' + status,
				success: function(response) {
					if (!response.error) {
						toastr.success(response.success, 'Success');
						resetDataTable();
						organizationsData();
					}
				}
			});
		});
	};

	function resetDataTable() {
		$('#organizationsData').DataTable().clear();
		$('#organizationsData').DataTable().destroy();
	}

	$('#deleteOrganization').on('submit', function(e) {
		e.preventDefault();
		var form = $('#deleteOrganization');
		var id = $('#deleteOrganizationId').val();
		var url = '/delete-organization/' + id;
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			success: function(response) {
				if (!response.error) {
					$('#message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response + '</div>');
					$("#deleteOrganization")[0].reset();
					$('#deleteOrganizationModal').modal('hide');
					resetDataTable();
					organizationsData();
				}
			}
		});
	});
	$(document).ready(function() {
		$('#organizationsData thead tr:eq(1) th').each(function(i) {
			var title = $(this).text();
			var html = '';
			if (title == 'Name')
				html = '<input type="text" class="form-control" placeholder="Search"  class="' + title + '"/>';
			if (title == 'Name') {
				$(this).html(html);
				// $(this).html('<input type="text" placeholder="Search"  class="' + title + '" style="width: ' + width + '"/>');
				$('input', this).on('keyup change', function() {
					if ($('#organizationsData').DataTable().column(i).search() !== this.value) {
						$('#organizationsData').DataTable()
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			} else {
				$(this).html('');
			}
		});
		organizationsData();
	});
</script>
@endsection