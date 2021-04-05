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
		<h4 class="page-title mb-0">Roles</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fe fe-layout mr-2 fs-14"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Roles</a></li>
		</ol>
	</div>
	@if(in_array('CREATE_ROLE', auth()->user()->Permissions))
	<div class="page-rightheader">
		<div class="btn btn-list">
			<a href="{{url('/add-role')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Add Role </a>
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
				<div class="card-title">Roles Data</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="rolesData">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">Role</th>
								<th class="wd-15p border-bottom-0">Description</th>
								<th class="wd-10p border-bottom-0">Action</th>
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
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Role</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deleteRoleForm">
					@csrf
					<input type="hidden" name="deleteRoleId" id="deleteRoleId">
					<p>Are you sure you want to delete this Role?</p>
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
	function roleData() {
		var dt = $('#rolesData').DataTable({
			"processing": false,
			"serverSide": false,
			"ajax": {
				url: '/getRoles',
				type: "GET",
			},
			select: true,
			"columns": [{
					"data": "name",
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
					"data": "role_desc",
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
			window.location.href = '/role/' + data['id'];
		});
		dt.on('click', 'td .deleteRole', function(e) {
			var id = $(this).attr('data-id');
			$('#deleteRoleModal').modal('show');
			$.ajax({
				type: "GET",
				url: 'getRole/' + id,
				success: function(response) {
					if (!response.error) {
						$('#deleteRoleId').val(response.id);
					}
				}
			});
		});
	};

	function resetDataTable() {
		$('#rolesData').DataTable().clear();
		$('#rolesData').DataTable().destroy();
	}

	$('#deleteRoleForm').on('submit', function(e) {
		e.preventDefault();
		var form = $('#deleteRoleForm');
		var id = $('#deleteRoleId').val();
		var url = '/delete-role/' + id;
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			success: function(response) {
				if (!response.error) {
					$('#message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response + '</div>');
					$("#deleteRoleForm")[0].reset();
					$('#deleteRoleModal').modal('hide');
					resetDataTable();
					roleData();
				}
			}
		});
	});
	$(document).ready(function() {
		roleData();
	});
</script>
@endsection