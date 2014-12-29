@if ( ! is_null($toc))
	<div id="sidebar" class="sidebar-offcanvas nano">
		<div class="col-md-12 nano-content">
			<nav class="toc">
				{{ $toc }}
			</nav>
		</div>
	</div>
@endif