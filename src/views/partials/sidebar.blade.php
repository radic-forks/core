@if ( ! is_null($toc))
	<div id="sidebar" class="sidebar-offcanvas">
		<div class="col-md-12">
			<nav class="toc">
				{{ $toc }}
			</nav>
		</div>
	</div>
@endif