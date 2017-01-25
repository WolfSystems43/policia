@extends('layouts.material')

@section('title', $page->title)

@section('content')

<div class="container">
	<br>
	<h5>{{ $page->title }}</h5>
	
	<br>

	<?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($page->content); ?>


	@can('admin')
	<br>
	<span class="right">
	<a href="/admin/page/{{ $page->id }}/edit" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> Editar</a>
	</span>
	<br><br>
	@endcan

</div>
@endsection