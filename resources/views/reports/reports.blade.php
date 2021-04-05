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
		<h4 class="page-title mb-0">Reports</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fe fe-layout mr-2 fs-14"></i></a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Reports</a></li>
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
			<div class="card-header">
				<div class="card-title">Reports</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-nowrap" id="reportsData">
						<thead>
							<tr>
								<th class="wd-15p border-bottom-0">Name</th>
								<th class="wd-10p border-bottom-0">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Tickets Summary Report</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#selectUserModalTicketSummary"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
							<tr>
								<td>Organizations Summary Report</td>
								<td><a href="{{url('/getOrganizationSummary').'?returnType=pdf'}}" target="_blank"><i class="fa fa-eye"></i></a></td>
							</tr>
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
<div class="modal fade" id="selectUserModalTicketSummary" tabindex="-1" role="dialog" aria-labelledby="selectUserModalTicketSummary" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Select User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="selectUser" action="{{url('/getTicketSummary').'?returnType=pdf'}}">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<input type="hidden" name="returnType" value="pdf" />
								<label class="form-label">User</label>
								<select id="users" name="user" class="form-control">
									<option disabled selected>Select User</option>
								</select>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info">Save</button>
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
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#users').select2({
			ajax: {
				url: '/getUsersRawData',
				processResults: function(data, page) {
					return {
						results: data
					};
				}
			}
		});
	});
</script>
@endsection