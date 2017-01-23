@extends('layouts.material')

@section('content')

<div class="container">
	<br>
	<h5>{{ $page->title }}</h5>

	<div class="card-panel">
		<?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($page->content); ?>
	</div>


	@can('admin')	
	<span class="right">
	<a href="/admin/page/{{ $page->id }}/edit" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> Editar</a>
	</span>
	<br><br>
	@endcan

</div>
@endsection