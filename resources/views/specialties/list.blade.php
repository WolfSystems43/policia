@extends('layouts.material')

@section('title', 'Especializaciones')

@section('content')
<div class="container">
<br>
	<h5>Especializaciones</h5>
	<br>

	@foreach($specialties as $specialty)
	<a href="{{ route('specialty-view', $specialty->id) }}">
	<div class="card-panel hoverable">
	<div class="row">
		<div class="col s4 m3 l2">
			<center><img height="80" src="/img/divisas/especialidades/{{ $specialty->id }}.png" alt="{{ $specialty->name }}"></center>
		</div>
		<div class="col s8 m9 l10 black-text">
		<span class="flow-text"> {{ $specialty->acronym }}</span>
		<br><span>{{ $specialty->name }}</span>
		</div>
	</div>
	</div>
	</a>
	@endforeach


		@can('admin')	
		<span class="right">
		<a href="/admin/specialty/" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> Lista</a>
		</span>
		<br><br>
		@endcan
</div>

@endsection