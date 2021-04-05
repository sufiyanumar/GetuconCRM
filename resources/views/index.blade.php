						@extends('layouts.master')
						@section('css')
						<!-- Data table css -->
						<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
						<style>
							input.Status {
								width: 10px !important;

							}

							input.Organization {
								width: 120px !important;
							}

							input.Personnel {
								width: 40px !important;
							}

							input.Category {
								width: 86px !important;
							}

							input.Subject {
								width: 150px !important;
							}

							input.Priority {
								width: 45px !important;
							}

							.btn-status {
								box-shadow: 0 0px 10px -5px rgb(251 28 82 / 50%);
							}

							.scroll-able {
								/* overflow-y: auto; */
								/* overflow-y: scroll; */
								height: 300px;
							}
						</style>
						@endsection
						@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title mb-0">Hi! {{auth()->user()->first_name}}</h4>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fe fe-home mr-2 fs-14"></i>Home</a></li>
									<li class="breadcrumb-item active" aria-current="page"><a href="">Dashboard</a></li>
								</ol>
							</div>
							<div class="page-rightheader">
								<div class="btn btn-list">
									@if(in_array('VIEW_TICKETS', auth()->user()->Permissions))
									<a href="{{url('/tickets')}}" class="btn btn-warning"><i class="fe fe-list mr-1"></i> All Tickets </a>
									@endif
								</div>
							</div>
						</div>
						<!--End Page header-->
						@endsection
						@section('content')
						<!-- Row-1 -->
						<div class="row">
							@if(in_array('VIEW_TICKETS', auth()->user()->Permissions))
							<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
								<div class="card overflow-hidden dash1-card border-0">
									<div class="card-body">
										<p class=" mb-1 "><a href="{{url('/tickets')}}">Total Tickets</a></p>
										<h2 class="mb-1 number-font">{{$data['totalTickets']}}</h2>
										<small class="fs-12 text-muted"></small>
										<span class="ratio bg-warning"></span>
										<span class="ratio-text text-muted"></span>
									</div>
									<div id="spark1"></div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
								<div class="card overflow-hidden dash1-card border-0">
									<div class="card-body">
										<p class=" mb-1 "><a href="{{url('/tickets')}}">Open Tickets</a></p>
										<h2 class="mb-1 number-font">{{$data['totalOpenTickets']}}</h2>
										<small class="fs-12 text-muted"></small>
										<span class="ratio bg-info"></span>
										<span class="ratio-text text-muted"></span>
									</div>
									<div id="spark2"></div>
								</div>
							</div>
							@endif
							@if(in_array('VIEW_USERS', auth()->user()->Permissions))
							<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
								<div class="card overflow-hidden dash1-card border-0">
									<div class="card-body">
										<p class=" mb-1 "><a href="{{url('/users')}}">Total Users</a></p>
										<h2 class="mb-1 number-font">{{$data['totalUsers']}}</h2>
										<small class="fs-12 text-muted"></small>
										<span class="ratio bg-danger"></span>
										<span class="ratio-text text-muted"></span>
									</div>
									<div id="spark3"></div>
								</div>
							</div>
							@endif
							@if(in_array('VIEW_ORGANIZATIONS', auth()->user()->Permissions))
							<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
								<div class="card overflow-hidden dash1-card border-0">
									<div class="card-body">
										<p class=" mb-1"><a href="{{url('/organizations')}}">Total Organization</a></p>
										<h2 class="mb-1 number-font">{{$data['totalOrganization']}}</h2>
										<small class="fs-12 text-muted"></small>
										<span class="ratio bg-success"></span>
										<span class="ratio-text text-muted"></span>
									</div>
									<div id="spark4"></div>
								</div>
							</div>
							@endif
						</div>
						<!-- End Row-1 -->

						<!-- Row-2 -->
						@if(in_array('VIEW_TICKETS', auth()->user()->Permissions))
						<div class="row">
							<div class="col-xl-8 col-lg-8 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Tickets Opened</h3>
										<div class="card-options">
											<div class="btn-group p-0">
												<button class="btn btn-outline-light btn-sm graphButton" type="button" data-id="weekly">Week Wise</button>
												<button class="btn btn-outline-light btn-sm graphButton" type="button" data-id="monthly">Month Wise</button>
												<!-- <button class="btn btn-outline-light btn-sm" type="button">Year</button> -->
											</div>
										</div>
									</div>
									<div class="card-body mb-3">
										<div id="echart1" class="chart-tasks chart-dropshadow text-center mb-3"></div>
										<!-- <div class="text-center mt-2">
											<span class="mr-4"><span class="dot-label bg-primary"></span>Total Sales</span>
											<span><span class="dot-label bg-secondary"></span>Total Units Sold</span>
										</div> -->
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Recent Tickets</h3>
										<!-- <div class="card-options">
											<a href="{{url('/' . $page='#')}}" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Today</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Week</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Month</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Year</a>
											</div>
										</div> -->
									</div>
									<div class="card-body">
										<div class="latest-timeline scrollbar3" id="scrollbar3" style="height: 264px !important;">
											<ul class="timeline mb-0">
												@foreach($data['tickets'] as $ticket)
												<li class="mt-0">
													<div class="d-flex"><span class="time-data">{{$ticket->name}}</span><span class="ml-auto text-muted fs-11">{{$ticket->created_at}}</span></div>
												</li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif
						<!-- End Row-2 -->

						<!-- Row-3 -->
						<!-- <div class="row">
							<div class="col-xl-4 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Recent Customers</h3>
										<div class="card-options">
											<a href="{{url('/' . $page='#')}}" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Today</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Week</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Month</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Year</a>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="list-card">
											<span class="bg-warning list-bar"></span>
											<div class="row align-items-center">
												<div class="col-9 col-sm-9">
													<div class="media mt-0">
														<img src="{{URL::asset('assets/images/users/1.jpg')}}" alt="img" class="avatar brround avatar-md mr-3">
														<div class="media-body">
															<div class="d-md-flex align-items-center mt-1">
																<h6 class="mb-1">Lisa Marshall</h6>
															</div>
															<span class="mb-0 fs-13 text-muted">User ID:#2342<span class="ml-2 text-success fs-13 font-weight-semibold">Paid</span></span>
														</div>
													</div>
												</div>
												<div class="col-3 col-sm-3">
													<div class="text-right">
														<span class="font-weight-semibold fs-16 number-font">$558</span>
													</div>
												</div>
											</div>
										</div>
										<div class="list-card">
											<span class="bg-info list-bar"></span>
											<div class="row align-items-center">
												<div class="col-9 col-sm-9">
													<div class="media mt-0">
														<img src="{{URL::asset('assets/images/users/9.jpg')}}" alt="img" class="avatar brround avatar-md mr-3">
														<div class="media-body">
															<div class="d-md-flex align-items-center mt-1">
																<h6 class="mb-1">John Chapman</h6>
															</div>
															<span class="mb-0 fs-13 text-muted">User ID:#6720<span class="ml-2 text-danger fs-13 font-weight-semibold">Pending</span></span>
														</div>
													</div>
												</div>
												<div class="col-3 col-sm-3">
													<div class="text-right">
														<span class="font-weight-semibold fs-16 number-font">$458</span>
													</div>
												</div>
											</div>
										</div>
										<div class="list-card">
											<span class="bg-danger list-bar"></span>
											<div class="row align-items-center">
												<div class="col-9 col-sm-9">
													<div class="media mt-0">
														<img src="{{URL::asset('assets/images/users/2.jpg')}}" alt="img" class="avatar brround avatar-md mr-3">
														<div class="media-body">
															<div class="d-md-flex align-items-center mt-1">
																<h6 class="mb-1">Sonia Smith </h6>
															</div>
															<span class="mb-0 fs-13 text-muted">User ID:#8763<span class="ml-2 text-success fs-13 font-weight-semibold">Paid</span></span>
														</div>
													</div>
												</div>
												<div class="col-3 col-sm-3">
													<div class="text-right">
														<span class="font-weight-semibold fs-16 number-font">$358</span>
													</div>
												</div>
											</div>
										</div>
										<div class="list-card">
											<span class="bg-success list-bar"></span>
											<div class="row align-items-center">
												<div class="col-9 col-sm-9">
													<div class="media mt-0">
														<img src="{{URL::asset('assets/images/users/11.jpg')}}" alt="img" class="avatar brround avatar-md mr-3">
														<div class="media-body">
															<div class="d-md-flex align-items-center mt-1">
																<h6 class="mb-1">Joseph Abraham</h6>
															</div>
															<span class="mb-0 fs-13 text-muted">User ID:#1076<span class="ml-2 text-danger fs-13 font-weight-semibold">Pending</span></span>
														</div>
													</div>
												</div>
												<div class="col-3 col-sm-3">
													<div class="text-right">
														<span class="font-weight-semibold fs-16 number-font">$796</span>
													</div>
												</div>
											</div>
										</div>
										<div class="list-card">
											<span class="bg-primary list-bar"></span>
											<div class="row align-items-center">
												<div class="col-9 col-sm-9">
													<div class="media mt-0">
														<img src="{{URL::asset('assets/images/users/3.jpg')}}" alt="img" class="avatar brround avatar-md mr-3">
														<div class="media-body">
															<div class="d-md-flex align-items-center mt-1">
																<h6 class="mb-1">Joseph Abraham</h6>
															</div>
															<span class="mb-0 fs-13 text-muted">User ID:#986<span class="ml-2 text-success fs-13 font-weight-semibold">Paid</span></span>
														</div>
													</div>
												</div>
												<div class="col-3 col-sm-3">
													<div class="text-right">
														<span class="font-weight-semibold fs-16 number-font">$867</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4  col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Revenue by customers in Countries</h3>
										<div class="card-options">
											<a href="{{url('/' . $page='#')}}" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Today</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Week</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Month</a>
												<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Year</a>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="country-card">
											<div class="mb-5">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/us.svg')}}" class="w-5 h-5 mr-2" alt="">United States</span>
													<div class="ml-auto"><span class="text-success mr-1"><i class="fe fe-trending-up"></i></span><span class="number-font">$45,870</span> (86%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 80%"></div>
												</div>
											</div>
											<div class="mb-5">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/in.svg')}}" class="w-5 h-5 mr-2" alt="">India</span>
													<div class="ml-auto"><span class="text-danger mr-1"><i class="fe fe-trending-down"></i></span><span class="number-font">$32,879</span> (65%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 60%"></div>
												</div>
											</div>
											<div class="mb-5">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/ru.svg')}}" class="w-5 h-5 mr-2" alt="">Russia</span>
													<div class="ml-auto"><span class="text-success mr-1"><i class="fe fe-trending-up"></i></span><span class="number-font">$22,710</span> (55%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 50%"></div>
												</div>
											</div>
											<div class="mb-5">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/ca.svg')}}" class="w-5 h-5 mr-2" alt="">Canada</span>
													<div class="ml-auto"><span class="text-danger mr-1"><i class="fe fe-trending-down"></i></span><span class="number-font">$56,291</span> (69%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 80%"></div>
												</div>
											</div>
											<div class="mb-5">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/ge.svg')}}" class="w-5 h-5 mr-2" alt="">Germany</span>
													<div class="ml-auto"><span class="text-success mr-1"><i class="fe fe-trending-up"></i></span><span class="number-font">$67,357</span> (73%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-teal" style="width: 70%"></div>
												</div>
											</div>
											<div class="mb-5">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/br.svg')}}" class="w-5 h-5 mr-2" alt="">Brazil</span>
													<div class="ml-auto"><span class="text-success mr-1"><i class="fe fe-trending-up"></i></span><span class="number-font">$34,209</span> (60%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-indigo" style="width: 60%"></div>
												</div>
											</div>
											<div class="mb-0">
												<div class="d-flex">
													<span class=""><img src="{{URL::asset('assets/images/flags/au.svg')}}" class="w-5 h-5 mr-2" alt="">Australia</span>
													<div class="ml-auto"><span class="text-success mr-1"><i class="fe fe-trending-up"></i></span><span class="number-font">$12,876</span> (46%)</div>
												</div>
												<div class="progress h-2  mt-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 40%"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4  col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<p class=" mb-1 fs-14">Users</p>
												<h2 class="mb-0"><span class="number-font1">12,769</span><span class="ml-2 text-muted fs-11"><span class="text-danger"><i class="fa fa-caret-down"></i> 43.2</span> this month</span></h2>

											</div>
											<span class="text-primary fs-35 dash1-iocns bg-primary-transparent border-primary"><i class="las la-users"></i></span>
										</div>
										<div class="d-flex mt-4">
											<div>
												<span class="text-muted fs-12 mr-1">Last Month</span>
												<span class="number-font fs-12"><i class="fa fa-caret-up mr-1 text-success"></i>10,876</span>
											</div>
											<div class="ml-auto">
												<span class="text-muted fs-12 mr-1">Last Year</span>
												<span class="number-font fs-12"><i class="fa fa-caret-down mr-1 text-danger"></i>88,345</span>
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<p class=" mb-1 fs-14">Sales</p>
												<h2 class="mb-0"><span class="number-font1">$34,789</span><span class="ml-2 text-muted fs-11"><span class="text-success"><i class="fa fa-caret-up"></i> 19.8</span> this month</span></h2>
											</div>
											<span class="text-secondary fs-35 dash1-iocns bg-secondary-transparent border-secondary"><i class="las la-hand-holding-usd"></i></span>
										</div>
										<div class="d-flex mt-4">
											<div>
												<span class="text-muted fs-12 mr-1">Last Month</span>
												<span class="number-font fs-12"><i class="fa fa-caret-up mr-1 text-success"></i>$12,786</span>
											</div>
											<div class="ml-auto">
												<span class="text-muted fs-12 mr-1">Last Year</span>
												<span class="number-font fs-12"><i class="fa fa-caret-down mr-1 text-danger"></i>$89,987</span>
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-end justify-content-between">
											<div>
												<p class=" mb-1 fs-14">Subscribers</p>
												<h2 class="mb-0"><span class="number-font1">4,876</span><span class="ml-2 text-muted fs-11"><span class="text-success"><i class="fa fa-caret-up"></i> 0.8%</span> this month</span></h2>
											</div>
											<span class="text-info fs-35 bg-info-transparent border-info dash1-iocns"><i class="las la-thumbs-up"></i></span>
										</div>
										<div class="d-flex mt-4">
											<div>
												<span class="text-muted fs-12 mr-1">Last Month</span>
												<span class="number-font fs-12"><i class="fa fa-caret-up mr-1 text-success"></i>1,034</span>
											</div>
											<div class="ml-auto">
												<span class="text-muted fs-12 mr-1">Last Year</span>
												<span class="number-font fs-12"><i class="fa fa-caret-down mr-1 text-danger"></i>8,610</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> -->
						<!-- End Row-3 -->
						<!--Row-->
						@if(in_array('VIEW_TICKETS', auth()->user()->Permissions))
						<div class="page-header">
							<div class="page-leftheader">
								<div class="pt-5">
									<!-- @foreach($data['status'] as $status)
									<a class="btn btn-status statusFilter" data-id="{{$status->id}}" style="color:{{$status->StatusColor['text-color']}};background-color: {{$status->StatusColor['background']}};background-color: {{$status->StatusColor['border']}};">
										{{$status->name}}
										{{$data['transferedTickets']}}
									</a>
									@endforeach -->
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
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Tickets List</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered text-wrap" id="ticketsData" width="100%">
												<thead>
													<tr class="bg-light">
														<th class="border-bottom-0" style="width:30px;">No#</th>
														<th class="border-bottom-0">Organization</th>
														<th class="border-bottom-0" style="width:30px;">Personnel</th>
														<th class="status wd-15p border-bottom-0">Status</th>
														<th class="wd-15p border-bottom-0">Category</th>
														<th class="wd-15p border-bottom-0">Subject</th>
														<th class="wd-15p border-bottom-0">Priority</th>
														<th class="wd-20p border-bottom-0" style="width:10%;">Ticket Date</th>
														<th class="wd-20p border-bottom-0" style="width:10%;">Due Date</th>
														<th class="wd-10p border-bottom-0" style="width: 10%;">Action</th>
													</tr>
													<tr class="bg-dark">
														<th class="border-bottom-0" style="width:30px;">No#</th>
														<th class="border-bottom-0">Organization</th>
														<th class="border-bottom-0" style="width:30px;">Personnel</th>
														<th class="status wd-15p border-bottom-0">Status</th>
														<th class="wd-15p border-bottom-0">Category</th>
														<th class="wd-15p border-bottom-0">Subject</th>
														<th class="wd-15p border-bottom-0">Priority</th>
														<th class="wd-20p border-bottom-0" style="width:10%;">Ticket Date</th>
														<th class="wd-20p border-bottom-0" style="width:10%;">Due Date</th>
														<th class="wd-10p border-bottom-0" style="width: 15%;">Action</th>
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
						@endif
						<!--End row-->
						<!--Row-->
						@if(in_array('VIEW_ORGANIZATIONS', auth()->user()->Permissions))
						<!-- <div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Recent Organizations</h3>
									</div>
									<div class="card-body min-height-300">
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top scroll-able">
												<thead class="">
													<tr>
														<th>Name</th>
														<th>City</th>
														<th>Phone</th>
														<th>Contract</th>
														<th>Contract Price</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($data['recentOrganizations'] as $recentOrganization)
													<tr>
														<td class="font-weight-bold">{{$recentOrganization->org_name}}</td>
														<td>{{$recentOrganization->city}}</td>
														<td>{{$recentOrganization->phone_no}}</td>
														<td>{{$recentOrganization->contract}}</td>
														<td class="number-font">{{$recentOrganization->price}}</td>
														<td><a href="{{url('organization').'/'.$recentOrganization->id}}"><i class="fa fa-eye"></i></a></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Recent Users</h3>
									</div>
									<div class="card-body min-height-300">
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top scroll-able">
												<thead class="">
													<tr>
														<th>First name</th>
														<th>Email</th>
														<th>Organization</th>
														<th>Role</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($data['recentUsers'] as $recentUser)
													<tr>
														<td class="font-weight-bold">{{$recentUser->first_name}}</td>
														<td>{{$recentUser->email}}</td>
														<td>{{$recentUser->organizationName}}</td>
														<td class="number-font">{{$recentUser->roleName}}</td>
														<td><a href="{{url('user').'/'.$recentUser->id}}"><i class="fa fa-eye"></i></a></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div> -->
						@endif
						<!--End row-->


						</div>
						</div>
						<!-- End app-content-->
						</div>
						@endsection
						@section('js')

						<!--INTERNAL Peitychart js-->
						<script src="{{URL::asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
						<script src="{{URL::asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>

						<!--INTERNAL Apexchart js-->
						<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>

						<!--INTERNAL ECharts js-->
						<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>

						<!--INTERNAL Chart js -->
						<script src="{{URL::asset('assets/plugins/chart/chart.bundle.js')}}"></script>
						<script src="{{URL::asset('assets/plugins/chart/utils.js')}}"></script>

						<!-- INTERNAL Select2 js -->
						<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
						<script src="{{URL::asset('assets/js/select2.js')}}"></script>

						<!--INTERNAL Moment js-->
						<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

						<!--INTERNAL Index js-->
						<script src="{{URL::asset('assets/js/index1.js')}}"></script>

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
										}, {
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
											"data": "personnel",
											"visible": true,
											"orderable": false,
											"searchable": true,
											render: function(data, type, row) {
												if (data)
													return row['PersonnelName'];
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
											"orderable": true,
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
											"data": "due_date",
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
									if (data)
										window.location.href = '/ticket/' + data['id'];
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
							$('.statusFilter').on('click', function() {
								var status = $(this).attr('data-id');
								if (status == 10) {
									alert('Yes');
								}
								resetDataTable();
								ticketsData(status);
							});
							$(document).ready(function() {
								$('#ticketsData thead tr:eq(1) th').each(function(i) {
									var title = $(this).text();
									var width;
									if (title == 'No#')
										width = '15px';
									if (title == 'Organization')
										width = '120px';
									if (title == 'Personnel')
										width = '40px';
									if (title == 'Category')
										width = '85px';
									if (title == 'Subject')
										width = '100px';
									if (title == 'Priority')
										width = '65px';
									if (title != 'Status' && title != 'Ticket Date' && title != 'Due Date' && title != 'Action') {
										$(this).html('<input type="text" placeholder="Search" class="form-control ' + title + '" style="width: ' + width + '"/>');
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