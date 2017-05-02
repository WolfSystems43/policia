@extends('layouts.material')

@section('title', trans('messages.frequencies_title'))

@section('content')
	<br>
<div class="container">
	<div class="card-panel">
		<h5>¡Gracias por tu interés!</h5>
		<p>Las frecuencias se encuentran ahora en el nuevo sistema de servicios.</p>
		<br>
		<a href="{{ route('start-work') }}" class="btn blue waves-effect">Entrar al servicio</a>
	</div>
</div>
@endsection
