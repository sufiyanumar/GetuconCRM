@extends('layouts.master')
@section('css')
<!--INTERNAL Select2 css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Role</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/roles')}}"><i class="fe fe-file-text mr-2 fs-14"></i>Roles</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">{{$role->name}}</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			@if(in_array('UPDATE_ROLE', auth()->user()->Permissions))
			<a href="{{url('/update-role').'/'.$role->id}}" class="btn btn-warning"><i class="fe fe-edit mr-1"></i>Edit</a>
			@endif
			@if(in_array('DELETE_ROLE', auth()->user()->Permissions))
			@if(!$role->system)
			<a href="#" data-toggle="modal" data-target="#deleteRoleModal" class="btn btn-danger"><i class="fe fe-trash mr-1"></i> Delete </a>
			@endif
			@endif
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
				<h3 class="card-title">Role Information</h3>
			</div>
			<div class="card-body">

				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group">
							<label class="form-label">Name</label>
							<div class="input-group">
								<span>{{$role->name}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4">
						<div class="form-group">
							<label class="form-label">Description</label>
							<div class="input-group">
								<span>{{$role->role_desc}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header">
				<h3 class="card-title">Permissions</h3>
			</div>
			<div class="card-body">
				<div class="row">
					@foreach($role['permissions'] as $permission)
					<div class="col-lg-6 col-md-6">
						<div class="form-group">
							<div class="input-group">
								<span>{{$permission->permissionSlug}}</span>
							</div>
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
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Organization</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deleteRoleForm">
					@csrf
					<input type="hidden" name="deleteRoleId" id="deleteRoleId" value="{{$role->id}}">
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
<script>
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
					$("#deleteRoleForm")[0].reset();
					$('#deleteRoleModal').modal('hide');
					window.location.href = "/roles";
					$('#message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response + '</div>');
				}
			}
		});
	});
</script>
@endsection