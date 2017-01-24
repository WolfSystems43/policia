@extends('layouts.material')

@section('title', 'Ajustes')

@section('content')
	<div class="container">
		<br>
		<h5>Ajustes</h5>
		<div class="card-panel">
		  <form action="#" method="post">
		  {{ csrf_field() }}
		  <p>Ajustes visuales</p>
		    <p>
		      <input type="checkbox" name="dark_mode" class="filled-in" id="filled-in-box" @if(session('dark', false)) checked="checked" @endif />
		      <label for="filled-in-box">Modo oscuro</label>
		    </p>
			
			<br>
		    <button type="submit" class="btn">Guardar ajustes</button>
		  </form>
		</div>
	</div>
@endsection