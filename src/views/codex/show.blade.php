@extends('codex::layouts.master')

@section('content')
	<div class="col-lg-12 documentation">
		<p class="pull-right">
			<small>{{ $lastUpdated }}</small>
		</p>

		{{ $content }}

		@include('codex::partials.footer')
	</div>
@stop
