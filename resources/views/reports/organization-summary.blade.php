<!DOCTYPE html>
<html>

<head>
	<title>Organization Summary</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<link rel="icon" href="{{URL::asset('assets/images/brand/favicon.ico')}}" type="image/x-icon" />
	<!--Bootstrap css -->
	<link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	<!-- Style css -->
	<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('assets/css/dark.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet" />
	<!-- Animate css -->
	<link href="{{URL::asset('assets/css/animated.css')}}" rel="stylesheet" />
	<!--Sidemenu css -->
	<link href="{{URL::asset('assets/css/sidemenu.css')}}" rel="stylesheet">
	<!-- P-scroll bar css-->
	<link href="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />
</head>

<body class="container">
	@foreach($organizations as $organization)
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">{{$organization->org_name}}</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Contract</label>
								<div class="input-group">
									<span>{{$organization->contract}}</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Contract Start Date</label>
								<div class="input-group">
									<span>{{$organization->contract_start_date}}</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Contract End Date</label>
								<div class="input-group">
									<span>{{$organization->contract_end_date}}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row pt-5">
						<div class="table-responsive">
							<table class="table table-bordered text-nowrap" id="ticketsData">
								<thead>
									<tr>
										<th class="wd-15p border-bottom-0">Ticket</th>
										<th class="wd-15p border-bottom-0">User</th>
										<th class="wd-15p border-bottom-0">Personnel</th>
										<th class="wd-15p border-bottom-0">Current Stataus</th>
									</tr>
								</thead>
								@if(isset($organization['tickets']))
								<tbody>
									@foreach($organization['tickets'] as $tickets)
									<tr>
										<th>{{$tickets->name}}
										<th>{{$tickets->UserName}}
										<th>{{$tickets->PersonnelName}}
										<th>{{$tickets->StatusName}}
									</tr>
									@endforeach
								</tbody>
								@endif
							</table>
						</div>
					</div>
					<div style="page-break-after: always;"></div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	</div><!-- end app-content-->
	</div>
</body>