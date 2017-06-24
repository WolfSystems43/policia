@extends('layouts.material')

@section('title', 'Ajustes')

@section('variables')

@php
$unlock_page = true;
@endphp

@endsection

@section('content')
	<div class="container">
		<br>
		<h5>Ajustes</h5>
		<div class="card-panel">
		  <form action="#" method="post">
		  {{ csrf_field() }}
			
			<div class="row">
				<div class="col s12">
				    <div class="input-field">
				      <input type="checkbox" name="dark_mode" class="filled-in" id="filled-in-box" @if(session('dark', false)) checked="checked" @endif />
				      <label for="filled-in-box">Modo oscuro</label>
				    </div>	
				</div>
				<br><br><br><br>
				<div class="col s12">
					<div class="input-field">
				    	<input id="email_input" type="email" value="{{ Auth::user()->email }}" readonly="readonly">
				    	<label for="email_input">Correo electrónico</label>
					</div>
				</div>
				<div class="col s12">
				  <!-- Disabled Switch -->
				  <div class="switch">
				    <label>
				      Solo notificaciones críticas
				      <input type="checkbox" name="email_enabled" @if(Auth::user()->emailEnabled()) checked="checked" @endif>
				      <span class="lever"></span>
				      Todas las notificaciones
				    </label>
				  </div>
				</div>
			</div>
			<br>
		    <button type="submit" class="btn green waves-effect">Guardar</button>
		  </form>
		</div>
		@if(Auth::user()->locked)
			<a class=" disabled btn red waves-effect right"><i class="material-icons left">highlight_off</i> Dimitir</a>
			<br><br><small class="right">Tienes una dimisión en curso.</small>
		@else
			<a href="{{ route('ticket_new_resign') }}" class="btn red waves-effect right"><i class="material-icons left">highlight_off</i> Dimitir</a>
		@endif
	</div>
@endsection