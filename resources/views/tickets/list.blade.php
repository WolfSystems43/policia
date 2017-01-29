@extends('layouts.material')

@section('title', 'Lista de tickets')

@section('content')

@include('tickets.menu')

<div class="container">
	<br>
	<h5>{{ $title }}</h5>

	<div class="card-panel">
		 <table class="highlight">
		    <thead>
		      <tr>
		          <th data-field="id">Asunto</th>
		          <th data-field="name">Estado</th>
		          <th data-field="name">Respuestas</th>
		          <th data-field="price">Última respuesta</th>
		      </tr>
		    </thead>
		
		    <tbody>
		    @foreach($tickets as $ticket)
		      <tr>
		        <td><a href="{{ route('ticket', ['id' => $ticket->id]) }}">{{ str_limit($ticket->title, 40) }}</a></td>
		        <td>
		        	<i class="material-icons left">{{ $ticket->getStatus()['icon'] }}</i> {{ $ticket->getStatus()['text'] }}
		        </td>
		        <td>{{ $ticket->replies->count() }}</td>
		        <td>@if($ticket->replies->count() > 0)
					{{ $ticket->getLastReply()->getCreatedDiff() }}
					@endif
		        </td>
		      </tr>
		      @endforeach
		      @if($tickets->count() == 0)
				<p>Ningún ticket abierto.</p>
			  @endif
		    </tbody>
		</table>

	</div>

	{{ $tickets->links() }}
</div>
@endsection