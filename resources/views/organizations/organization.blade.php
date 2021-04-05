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
		<h4 class="page-title mb-0">Organization</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/organizations')}}"><i class="fe fe-file-text mr-2 fs-14"></i>Organizations</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">{{$organization->org_name}}</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
		<div class="btn btn-list">
			@if(in_array('UPDATE_ORGANIZATION', auth()->user()->Permissions))
			<a href="{{url('/update-organization').'/'.$organization->id}}" class="btn btn-theme"><i class="fe fe-edit mr-1"></i> Edit </a>
			@endif
			@if(in_array('DELETE_ORGANIZATION', auth()->user()->Permissions))
			<a href="#" data-toggle="modal" data-target="#deleteOrganizationModal" class="btn btn-danger"><i class="fe fe-trash mr-1"></i> Delete </a>
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
				<h3 class="card-title">Organization Information</h3>
			</div>
			<div class="card-body">
				<div class="row mb-5">
					<div class="col-lg-6 col-md-6">
						@if($organization->picture)
						<img src="{{asset('/storage/uploadsnew/OrgImage') . '/' . $organization->picture}}" alt="img" style="max-width: 200px;">
						@else
						<img src="https://ui-avatars.com/api/?name={{$organization->org_name}}&background=5E72E4&color=fff&size=40" alt="img" class="avatar avatar-md brround">
						@endif
					</div>
				</div>
				<div class="row ">
					<div class="col-lg-6 col-md-6 border pt-5 bg-theme text-white">
						<div class="form-group">
							<label class="form-label">Organization Name</label>
							<div class="input-group">
								<span>{{$organization->org_name}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 border pt-5">
						<div class="form-group">
							<label class="form-label">Phone</label>
							<div class="input-group">
								<span>{{$organization->phone_no}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 border pt-5">
						<div class="form-group">
							<label class="form-label">Email</label>
							<div class="input-group">
								<span>{{$organization->email}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 border pt-5">
						<div class="form-group">
							<label class="form-label">GSM</label>
							<div class="input-group">
								<span>{{$organization->gsm}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 border pt-5">
						<div class="form-group">
							<label class="form-label">Address</label>
							<div class="input-group">
								<span>{{$organization->address}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 border pt-5">
						<div class="form-group">
							<label class="form-label">City</label>
							<div class="input-group">
								<span>{{$organization->city}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 border pt-5">
						<div class="form-group">
							<label class="form-label">Zip Code</label>
							<div class="input-group">
								<span>{{$organization->zip_code}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 border pt-5">
						<div class="form-group">
							<label class="form-label">Rating</label>
							<div class="input-group">
								@if($organization->rating == 1)
								<span>Blacklist Client <i class="fa fa-flag btn btn-danger"></i></span>
								@endif
								@if($organization->rating == 2)
								<span>Normal Client <i class="fa fa-flag btn btn-theme"></i></span>
								@endif
								@if($organization->rating == 3)
								<span>Good Client <i class="fa fa-flag btn btn-success"></i></span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header border-0">
				<h3 class="card-title">Contract Information</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6 col-md-6 border pt-2">
						<div class="form-group">
							<label class="form-label">Contract</label>
							<div class="input-group">
								<span>{{$organization->contract}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 border pt-2">
						<div class="form-group">
							<label class="form-label">Contract Frequency</label>
							<div class="input-group">
								<span>{{$organization->contract_frequency}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 border pt-2">
						<div class="form-group">
							<label class="form-label">Contract Start Date</label>
							<div class="input-group">
								<span>{{$organization->contract_start_date}}</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 border pt-2">
						<div class="form-group">
							<label class="form-label">Contract End Date</label>
							<div class="input-group">
								<span>{{$organization->contract_end_date}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 border pt-2">
						<div class="form-group">
							<label class="form-label">Contract Price</label>
							<div class="input-group">
								<span>{{$organization->price}}<small> Per 15 minutes</small></span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 border pt-2">
						<div class="form-group">
							<label class="form-label">Contract Price</label>
							<div class="input-group">
								<span>{{$organization->price_monthly}}<small> Monthly</small></span>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3  border pt-2">
						<div class="form-group">
							<label class="form-label">Transport Price</label>
							<div class="input-group">
								<span>{{$organization->transport_price}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header border-0">
				<h3 class="card-title">Users</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="usersData">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">Name</th>
								<th class="wd-15p border-bottom-0">Email</th>
								<th class="wd-20p border-bottom-0">Role</th>
								<th class="wd-15p border-bottom-0">Phone</th>
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
					<input type="hidden" name="deleteOrganizationId" id="deleteOrganizationId" value="{{$organization->id}}">
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
	function userData() {
		var dt = $('#usersData').DataTable({
			"processing": false,
			"serverSide": false,
			"ajax": {
				url: '/getOrganizationUsers/' + <?php echo $organization->id; ?>,
				type: "GET",
			},
			select: true,
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
					"data": "role",
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
					"data": "phone",
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
			"iDisplayLength": 5
		});
		// dt.on('click', 'tbody tr td:not(:last-child)', function(e) {
		// 	var data = dt.row($(this).parents('tr')).data();
		// 	window.location.href = '/organization/' + data['id'];
		// });
		// dt.on('click', 'td .deleteOrganization', function(e) {
		// 	var id = $(this).attr('data-id');
		// 	$('#deleteOrganizationModal').modal('show');
		// 	$.ajax({
		// 		type: "GET",
		// 		url: 'getOrganization/' + id,
		// 		success: function(response) {
		// 			if (!response.error) {
		// 				$('#deleteOrganizationId').val(response.id);
		// 			}
		// 		}
		// 	});
		// });
	};
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
					$("#deleteOrganization")[0].reset();
					$('#deleteOrganizationModal').modal('hide');
					window.location.href = "/organizations";
					$('#message').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response + '</div>');
				}
			}
		});
	});
	$(document).ready(function() {
		userData();
	});
</script>
@endsection