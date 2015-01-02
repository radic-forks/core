@extends('codex::layouts.master')

@section('content')
	<div class="col-lg-12 documentation">
		<div class="row">
			<div class="col-lg-12">
				<p>
					<span class="pull-left">
						@if (isset($meta['author']))
							<small>Authored By <b>{{ $meta['author'] }}</b></small>
						@endif
					</span>

					<span class="pull-right">
						<small>{{ $lastUpdated }}</small>
					</span>
				</p>
			</div>
		</div>

		{{ $content }}

		@include('codex::partials.footer')
	</div>
@stop
