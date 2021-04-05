<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<!-- Meta data -->
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
	<!---Icons css-->
	<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="{{URL::asset('assets/plugins/simplebar/css/simplebar.css')}}">
	<link id="theme" href="{{URL::asset('assets/colors/color1.css')}}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="app sidebar-mini">
	<div class="container">
		@yield('content')
	</div>

</body>

</html>