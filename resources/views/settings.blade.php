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
		<a href="#modal-disable" class="btn white red-text waves-effect right"><i class="material-icons left">highlight_off</i> Dar de baja la cuenta</a>
	<!-- Modal dar de baja -->
	<div id="modal-disable" class="modal">
		<div class="modal-content">
			<h5>Dar de baja la cuenta</h5>
			<p>Si has dejado la Policía, te animamos a, en un ejercicio de honestidad e integridad, desactivar tu cuenta por ti mismo.</p>
			<p>Muchas gracias por tu aportación y duro trabajo.</p>
			<p><b>Esta acción no se puede deshacer.</b><br><small>Se notificará a los comisarios.</small></p>
		</div>
		<div class="modal-footer">
			<form action="{{ route('disable-account') }}" method="POST">
				{{ csrf_field() }}
				<button type="submit" class="waves-effect red-text btn-flat">Dar de baja</button>
			</form>
			<a href="#!" class="modal-action blue-text modal-close waves-effect btn-flat">Cancelar</a>
		</div>
	</div>
	</div>
@endsection