@extends('layouts.material')

@section('title', 'Ticket #'.$ticket->id)

@section('content')

@include('tickets.menu')

<div class="container">
	<br>
	<h5>{{ $ticket->getTypeName() }} #{{ $ticket->id }}</h5>
	

	<div class="row">
		<div class="col s12 m6">
			<p>Asunto</p>
			<div class="card-panel"><p>{{ $ticket->title }}</p></div>
		</div>
		<div class="col s12 m6">
			<p>Estado</p>
			<div class="card-panel">
				<p>
					<i class="material-icons left">{{ $ticket->getStatus()['icon'] }}</i> {{ $ticket->getStatus()['text'] }}

					@if($ticket->closed && !is_null($ticket->closed_at))
						<small>{{ $ticket->getClosedDiff() }}</small>
					@endif
				</p>
			</div>
		</div>
		<div class="col s12 m6">
			<p>Autor</p>
			<div class="card-panel">
			<p>
				@if($ticket->anonymous)
				<i class="material-icons left">visibility_off</i> <i>El usuario ha decidido no mostrar su nombre.</i>
				@else
				<a href="{{ route('user_profile', ['id' => $ticket->user->id]) }}"><img height="16" src="{{ $ticket->user->getCorpImage() }}"> <img height="16" src="{{ $ticket->user->getRankImage() }}"> {{ $ticket->user->name }}</a>
				@endif
			</p>
			</div>
		</div>
		<div class="col s12 m6">
			<p>Personas implicadas ({{ $ticket->usersInvolved->count() }})</p>
			<div class="card-panel">
				<p><ul>
				@foreach($ticket->usersInvolved->all() as $user)
					<li><a href="{{ route('user_profile', ['id' => $user->id]) }}"><img height="16" src="{{ $user->getCorpImage() }}"> <img height="16" src="{{ $user->getRankImage() }}"> {{ $user->getRankName() }} {{ $user->name }}</a></li>
				@endforeach
				</ul></p>
			</div>
		</div>		
	</div>
	

	<p>Descripción de los hechos</p>
	<div class="card-panel">
		{!! nl2br(e($ticket->body)) !!}
	</div>
	
	<br>
	<h5>Respuestas</h5>
	@foreach($ticket->replies as $reply)
		<br>
		<p>
		@if($reply->staff)
			@if(Auth::user()->isIA())
				<img height="16" src="/img/divisas/especialidades/6.png"> <b>Asuntos Internos</b> (<i>{{ $reply->user->name }}</i>)
			@else
				<img height="16" src="/img/divisas/especialidades/6.png"> <b>Asuntos Internos</b>
			@endif
		@else
			@if($ticket->anonymous)
				@if($reply->user == Auth::user())
					<i class="material-icons left">visibility_off</i> Anónimo <b>(Tú)</b>
				@else
					<i class="material-icons left">visibility_off</i> Anónimo
				@endif
			@else
				<a href="{{ route('user_profile', ['id' => $ticket->user->id]) }}"><img height="16" src="{{ $ticket->user->getCorpImage() }}"> <img height="16" src="{{ $ticket->user->getRankImage() }}"> {{ $ticket->user->name }}</a>
			@endif
		@endif
		- 	
		{{ $reply->getCreatedDiff() }}
		</p>
		<div class="card-panel @if($reply->system) yellow lighten-4 @endif">
			{!! nl2br(e($reply->body)) !!}
		</div>
	@endforeach
	
  

	@can('reply-ticket', $ticket)

	<br>
	<p>Responder</p>

	  @if (count($errors) > 0)
    <div class="card-panel">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

	<div class="card-panel">
	    <div class="row">
	      <form class="col s12" method="POST" action="{{ route('ticket_reply', ['id' => $ticket->id]) }}">
	      	{{ csrf_field() }}
	        <div class="row">
	          <div class="input-field col s12">
	            <textarea name="body" required="required" id="textarea1" class="materialize-textarea" length="500" placeholder="Mínimo 15 caracteres"></textarea>
	            <label for="textarea1">Respuesta</label>

		        
	          </div>
	        </div>
		        @if($ticket->anonymous && Auth::user() == $ticket->user)
		        <p><i class="material-icons left">visibility_off</i> Modo anónimo. Tu nombre no se mostrará.</p><br>
		        @endif
		        <button class="btn green waves-effect">Publicar respuesta</button>
	      </form>
	    </div>
	</div>
	@endcan
	
	@can('close-ticket', $ticket)
	<br>
	<div class="card-panel">
		@if($ticket->closed)
		<form method="POST" action="{{ route('ticket_open', ['id' => $ticket->id]) }}">
			{{ csrf_field() }}
			<button class="btn green waves-effect">Abrir ticket</button>
		</form>
		@else
		<a class="btn red waves-effect modal-trigger" href="#modalclose">Cerrar ticket</a>
		@endif
	</div>

	  <!-- Modal close -->
	  <div id="modalclose" class="modal">
	    <div class="modal-content">
	      <h4>Cerrar ticket</h4>
	      <p>Al cerrar el ticket, no se podrá responder más.</p>
			<form method="POST" action="{{ route('ticket_close', ['id' => $ticket->id]) }}">
				{{ csrf_field() }}
				<br>
				<div class="row">
				<div class="input-field col s12">
				  <select name="result" required="required">
				    <option value="" disabled selected>Resolución</option>
				    <option value="1">Solucionado</option>
				    <option value="2">Aceptado</option>
				    <option value="3">Rechazado</option>
				    <option value="0">Sin resolución específica/otros</option>
				  </select>
				  <label>Resolución del ticket</label>
				</div>	
				</div>

				<button class="btn red waves-effect">Cerrar ticket</button>
			</form>
			<br><br><br>
	    </div>
	    <div class="modal-footer">
	      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
	    </div>
	  </div>
          
	@endcan
	
	<br>
</div>
@endsection