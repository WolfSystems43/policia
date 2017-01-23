@extends('layouts.material')

@section('content')

<div class="container">
	<br>
	<h5>{{ $page->title }}</h5>

	<div class="card-panel">
		<?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($page->content); ?>
	</div>
</div>
@endsection