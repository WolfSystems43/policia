@extends('layouts.material')

@section('title', 'Condecoraciones')

@section('content')
<div class="container">
	<br>
	<h5>Condecoraciones</h5>

	<p>Medallas</p>
		<div class="card-panel">
		<br>
	@foreach($badges as $badge)
		<div class="row">
			<div class="col s4 m3 l2">
				@if(!is_null($badge->image))
				<center><img height="50" src="{{ url($badge->image) }}" alt="{{ $badge->name }}"></center>
				@endif
			</div>
			<div class="col s8 m9 l10 black-text">
			<b><a href="{{ route('badge', ['id' => $badge->id]) }}">{{ $badge->name }}</a></b>
			<br><span>0 concedidas</span>
			</div>
		</div>
	@endforeach
		</div>

	<p>Licencias</p>
	<div class="card-panel">
		<br>
		@foreach($licenses as $licence)
			<div class="row">
				<div class="col s4 m3 l2">
					@if(!is_null($licence->image))
					<center><img height="50" src="{{ url($licence->image) }}" alt="{{ $licence->name }}"></center>
					@endif
				</div>
				<div class="col s8 m9 l10 black-text">
				<b><a href="{{ route('badge', ['id' => $licence->id]) }}">{{ $licence->name }}</a></b>
				<br><span>0 concedidos</span>
				</div>
			</div>
		@endforeach	
	</div>

	<p>Diplomas</p>
	<div class="card-panel">
		<br>
		@foreach($certificates as $certificate)
			<div class="row">
				<div class="col s4 m3 l2">
					@if(!is_null($certificate->image))
					<center><img height="50" src="{{ url($certificate->image) }}" alt="{{ $certificate->name }}"></center>
					@endif
				</div>
				<div class="col s8 m9 l10 black-text">
				<b><a href="{{ route('badge', ['id' => $certificate->id]) }}">{{ $certificate->name }}</a></b>
				<br><span>0 concedidos</span>
				</div>
			</div>
		@endforeach	
	</div>



	<p></p>
</div>


@endsection