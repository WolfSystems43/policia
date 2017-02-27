@extends('layouts.material')

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
				<center><img height="50" src="{{ url($badge->image) }}" alt="{{ $badge->name }}"></center>
			</div>
			<div class="col s8 m9 l10 black-text">
			<b>{{ $badge->name }}</b>
			<br><span>0 concedidas</span>
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
				</div>
				<div class="col s8 m9 l10 black-text">
				<b>{{ $certificate->name }}</b>
				<br><span>0 concedidos</span>
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
				</div>
				<div class="col s8 m9 l10 black-text">
				<b>{{ $licence->name }}</b>
				<br><span>0 concedidos</span>
				</div>
			</div>
		@endforeach	
	</div>

	<p></p>
</div>


@endsection