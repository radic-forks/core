<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

		@if (isset($currentManual))
			<title>{{ Config::get('codex::site_name') }} - {{ $currentManual }} {{ $currentVersion }}</title>
		@else
			<title>{{ Config::get('codex::site_name') }}</title>
		@endif

		<!-- CSS -->
		<link rel="stylesheet" href="{{ asset('/packages/codexproject/core/css/bootswatch/flatly.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/packages/codexproject/core/css/prettify/freshcut.css') }}">
		<link rel="stylesheet" href="{{ asset('/packages/codexproject/core/css/nano.css') }}">
		<link rel="stylesheet" href="{{ asset('/packages/codexproject/core/css/codex.css') }}">
	</head>
	<body>
		@include('codex::partials.analytics_tracking')
		@include('codex::partials.navbar')

		<div id="wrapper">
			@include('codex::partials.sidebar')

			<div id="page-content-wrapper">
				<div class="container-fluid">
					<div class="row">
						@yield('content')
					</div>
				</div>
			</div>
		</div>

		<!-- Javascript -->
		<script src="{{ asset('/packages/codexproject/core/js/jquery-2.1.1.min.js') }}"></script>
		<script src="{{ asset('/packages/codexproject/core/js/jquery.nanoscroller.min.js') }}"></script>
		<script src="{{ asset('/packages/codexproject/core/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/packages/codexproject/core/js/prettify/run_prettify.js') }}"></script>
		<script src="{{ asset('/packages/codexproject/core/js/codex.js') }}"></script>
	</body>
</html>
