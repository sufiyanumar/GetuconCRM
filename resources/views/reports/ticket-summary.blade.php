<!DOCTYPE html>
<html>

<head>
	<title>Ticket Summary</title>
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
	@foreach($tickets as $ticket)
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">{{$ticket->name}}</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Description</label>
								<div class="input-group">
									@if($ticket->description)
									{{$ticket->description}}
									@else
									-
									@endif
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label class="form-label">Translation</label>
								<div class="input-group">
									@if($ticket->translate)
									{{$ticket->translate}}
									@else
									-
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
									{{$ticket->organizationName}}
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">User</label>
								<div class="input-group">
									{{$ticket->UserName}}
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Personnel</label>
								<div class="input-group">
									{{$ticket->PersonnelName}}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Current Status</label>
								<div class="input-group">
									<span>{{$ticket->StatusName}}</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Priority</label>
								<div class="input-group">
									<span>{{$ticket->PriorityName}}</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Category</label>
								<div class="input-group">
									<span>{{$ticket->CategoryName}}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Due Date</label>
								<div class="input-group">
									<span>{{$ticket->due_date}}</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="form-group">
								<label class="form-label">Transport Price</label>
								<div class="input-group">
									<span>{{$ticket->transport_price}}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3">
							<h4>Effort</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Good Will</label>
								<span>{{$ticket->good_will}}</span>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Coding</label>
								<span>{{$ticket->coding}}</span>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Consulting</label>
								<span>{{$ticket->consulting}}</span>
							</div>
						</div>
						<div class="col-lg-3 col-md-3">
							<div class="form-group">
								<label class="form-label">Testing</label>
								<span>{{$ticket->testing}}</span>
							</div>
						</div>
					</div>
					<div class="row pt-5">
						<div class="table-responsive">
							<table class="table table-bordered text-nowrap" id="ticketsData">
								<thead>
									<tr>
										<th class="wd-15p border-bottom-0">Status</th>
										<th class="wd-15p border-bottom-0">Change by</th>
										<th class="wd-15p border-bottom-0">Date</th>
									</tr>
								</thead>
								@if(isset($ticket['status']))
								<tbody>
									@foreach($ticket['status'] as $status)
									<tr>
										<th>{{$status->TicketStatusName}}
										<th>{{$status->StatusUserName}}
										<th>{{$status->created_at}}
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