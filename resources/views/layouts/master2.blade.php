<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<!-- Meta data -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta content="IT-CRM" name="description">
	<meta content="Spruko Technologies Private Limited" name="author">
	<meta name="keywords" content="IT-CRM" />
	@include('layouts.custom-head')
	<style>
		.login-bg {
			background: linear-gradient(rgba(0, 0, 0, 0.45),
					rgba(0, 0, 0, 0.45)), url('/assets/images/login-background.jpg');
			height: 100%;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>
</head>

<body class="h-100vh login-bg">
	@yield('content')
	@include('layouts.custom-footer-scripts')
</body>

</html>