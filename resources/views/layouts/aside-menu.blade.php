				<aside class="app-sidebar">
					<div class="app-sidebar__logo">
						<a class="header-brand" href="{{url('/dashboard')}}">
							<img src="{{URL::asset('assets/images/brand/getucon-logo.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
							<img src="{{URL::asset('assets/images/brand/logo1.png')}}" class="header-brand-img dark-logo" alt="Admintro logo">
							<img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Admintro logo">
							<img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Admintro logo">
						</a>
					</div>
					<div class="app-sidebar__user">
						<div class="dropdown user-pro-body text-center">
							<div class="user-pic">
								<img src="https://ui-avatars.com/api/?name={{auth()->user()->first_name}} {{auth()->user()->surname}}&background=5E72E4&color=fff&size=64" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							<div class="user-info">
								<h5 class=" mb-1">{{auth()->user()->first_name}} {{auth()->user()->surname}} <i class="ion-checkmark-circled  text-success fs-12"></i></h5>
								<!-- <span class="text-muted app-sidebar__user-name text-sm">Web Designer</span> -->
							</div>
						</div>
						<!-- <div class="sidebar-navs">
							<ul class="nav nav-pills-circle">
								<li class="nav-item" data-placement="top" data-toggle="tooltip" title="Support">
									<a class="icon" href="{{url('/' . $page='#')}}">
										<i class="las la-life-ring header-icons"></i>
									</a>
								</li>
								<li class="nav-item" data-placement="top" data-toggle="tooltip" title="Documentation">
									<a class="icon" href="{{url('/' . $page='#')}}">
										<i class="las  la-file-alt header-icons"></i>
									</a>
								</li>
								<li class="nav-item" data-placement="top" data-toggle="tooltip" title="Projects">
									<a href="{{url('/' . $page='#')}}" class="icon">
										<i class="las la-project-diagram header-icons"></i>
									</a>
								</li>
								<li class="nav-item" data-placement="top" data-toggle="tooltip" title="Settins">
									<a class="icon" href="{{url('/' . $page='#')}}">
										<i class="las la-cog header-icons"></i>
									</a>
								</li>
							</ul>
						</div> -->
					</div>
					<ul class="side-menu app-sidebar3">
						<li class="side-item side-item-category mt-4">Main</li>
						@if(auth()->user()->role_id != 5&&auth()->user()->role_id != 6)
						<li class="slide">
							<a class="side-menu__item" href="{{url('/dashboard')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
								</svg>
								<span class="side-menu__label">Dashboard</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_ORGANIZATIONS', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="{{url('/organizations')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M6.5 10h-2v7h2v-7zm6 0h-2v7h2v-7zm8.5 9H2v2h19v-2zm-2.5-9h-2v7h2v-7zm-7-6.74L16.71 6H6.29l5.21-2.74m0-2.26L2 6v2h19V6l-9.5-5z" />
								</svg>
								<span class="side-menu__label">Organizations</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_USERS', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="{{url('/users')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3" />
									<circle cx="12" cy="8" opacity=".3" r="2" />
									<path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" />
								</svg>
								<span class="side-menu__label">Users</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_ROLES', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="{{url('/roles')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M19 5v14H5V5h14m0-2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9c-1.65 0-3-1.35-3-3s1.35-3 3-3 3 1.35 3 3-1.35 3-3 3zm0-4c-.55 0-1 .45-1 1s.45 1 1 1 1-.45 1-1-.45-1-1-1zm6 10H6v-1.53c0-2.5 3.97-3.58 6-3.58s6 1.08 6 3.58V18zm-9.69-2h7.38c-.69-.56-2.38-1.12-3.69-1.12s-3.01.56-3.69 1.12z" />
								</svg>
								<span class="side-menu__label">Roles</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_TICKETS', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="{{url('/tickets')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0z" fill="none" />
									<path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
								</svg>
								<span class="side-menu__label">Tickets</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_TICKET_ATTACHMENTS', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="{{url('/ticket-attachment')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M12.5 23c3.04 0 5.5-2.46 5.5-5.5V6h-1.5v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-1.38 1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5z" />
								</svg>
								<span class="side-menu__label">Attachments</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_TICKET_ATTACHMENTS', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="#">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0z" fill="none" />
									<path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
								</svg>
								<span class="side-menu__label">Bill</span>
							</a>
						</li>
						@endif
						@if(in_array('VIEW_REPORTS', auth()->user()->Permissions))
						<li class="slide">
							<a class="side-menu__item" href="{{url('/reports')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none"></path>
									<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"></path>
								</svg>
								<span class="side-menu__label">Reports</span>
							</a>
						</li>
						@endif
					</ul>
				</aside>
				<!--aside closed-->