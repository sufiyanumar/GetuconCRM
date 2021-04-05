@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
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
		<h4 class="page-title mb-0">Users</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fe fe-layout mr-2 fs-14"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Users</a></li>
		</ol>
	</div>
	@if(in_array('CREATE_USER', auth()->user()->Permissions))
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{url('/add-user')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Add User </a>
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
			<div class="card-header">
				<div class="card-title">Users Data</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="usersData">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">First name</th>
								<th class="wd-15p border-bottom-0">Last name</th>
								<th class="wd-10p border-bottom-0">Email</th>
								<th class="wd-20p border-bottom-0">Organization</th>
								<th class="wd-15p border-bottom-0">Role</th>
								<th class="status wd-15p border-bottom-0">Status</th>
								<th class="wd-25p border-bottom-0">Action</th>
							</tr>
							<tr>
								<th class="wd-15p border-bottom-0">First name</th>
								<th class="wd-15p border-bottom-0">Last name</th>
								<th class="wd-10p border-bottom-0">Email</th>
								<th class="wd-20p border-bottom-0">Organization</th>
								<th class="wd-15p border-bottom-0">Role</th>
								<th class="status wd-15p border-bottom-0">Status</th>
								<th class="wd-25p border-bottom-0">Action</th>
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
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deleteUserForm">
					@csrf
					<input type="hidden" name="deleteUserId" id="deleteUserId">
					<p>Are you sure you want to delete this user?</p>
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
	function usersData() {
		var dt = $('#usersData').DataTable({
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
				url: '/getUsers',
				type: "GET",
			},
			select: true,
			"createdRow": function(row, data, dataIndex) {
				if (data['in_use'] == 0) {
					$(row).addClass('redClass');
				}
			},
			"columns": [{
					"data": "first_name",
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
					"data": "surname",
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
					"data": "email",
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
					"data": "organizationName",
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
					"data": "roleName",
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
					"data": "in_use",
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
			window.location.href = '/user/' + data['id'];
		});
		dt.on('click', 'td .deleteUser', function(e) {
			var id = $(this).attr('data-id');
			$('#deleteUserModal').modal('show');
			$.ajax({
				type: "GET",
				url: 'getUser/' + id,
				success: function(response) {
					if (!response.error) {
						$('#deleteUserId').val(response.id);
					}
				}
			});
		});
		dt.on('click', 'td .userStatus', function(e) {
			var userId = $(this).attr('data-id');
			var status = $(this).attr('data-status');
			$.ajax({
				type: "GET",
				url: '/updateUserStatus/' + userId + '?status=' + status,
				success: function(response) {
					if (!response.error) {
						toastr.success(response.success, 'Success');
						resetDataTable();
						usersData();
					}
				}
			});
		});
	};

	function resetDataTable() {
		$('#usersData').DataTable().clear();
		$('#usersData').DataTable().destroy();
	}
	$('#deleteUserForm').on('submit', function(e) {
		e.preventDefault();
		var form = $('#deleteUserForm');
		var id = $('#deleteUserId').val();
		var url = '/delete-user/' + id;
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			success: function(response) {
				if (!response.error) {
					$('#message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response + '</div>');
					$("#deleteUserForm")[0].reset();
					$('#deleteUserModal').modal('hide');
					resetDataTable();
					usersData();
				}
			}
		});
	});
	$(document).ready(function() {
		$('#usersData thead tr:eq(1) th').each(function(i) {
			var title = $(this).text();
			var html = '';
			html = '<input type="text" class="form-control" placeholder="Search"  class="' + title + '"/>';
			$(this).html(html);
			// $(this).html('<input type="text" placeholder="Search"  class="' + title + '" style="width: ' + width + '"/>');
			$('input', this).on('keyup change', function() {
				if ($('#usersData').DataTable().column(i).search() !== this.value) {
					$('#usersData').DataTable()
						.column(i)
						.search(this.value)
						.draw();
				}
			});
		});
		usersData();
	});
</script>
@endsection