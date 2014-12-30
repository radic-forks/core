<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a href="/" class="navbar-brand">{{ Config::get('codex::site_name') }}</a>
		</div>

		<div id="navbar" class="collapse navbar-collapse">
			@include('codex::partials.navbar_nav')

			@if (isset($currentManual))
				@include('codex::partials.search_form')
			@endif
		</div>
	</div>
</nav>
