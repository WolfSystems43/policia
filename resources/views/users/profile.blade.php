@extends('layouts.material')

@section('title', $user->name)

@section('content')
<div class="container">

	<br>
		<div class="row">
			<div class="col s3 m1">	
				<img height="85" src="{{ $user->getCorpImage() }}"> 
			</div>
			<div class="col s9 m11">
				<h5>{{ $user->name }}</h5>
				<span>{{ $user->getCorpName() }} <span class="right"><small>{{ trans('messages.profile_member_since', ['ago' => $user->getCreatedDiff()]) }}</small></span></span>

			</div>
		</div>
		
		<div class="card-panel">
			<div class="row">
				<div class="col s3 m1">	
					<img height="85" src="{{ $user->getRankImage() }}"> 
				</div>
				<div class="col s9 m11">
					<span class="flow-text">{{ $user->getRankName() }}</span><br>

				</div>
			</div>
		</div>
	
		<p>Especializaciones</p>
		<div class="card-panel">
			<?php $cuenta = 0; ?>
          @foreach($user->specialties()->get() as $specialty)
          @can('view-secret-specialty', $specialty)
          <?php $cuenta++; ?>
          <a href="{{ route('specialty-view', ['id' => $specialty->id]) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="{{ $specialty->acronym }}"><img height="70" src="/img/divisas/especialidades/{{ $specialty->id }}.png" alt="{{ $specialty->acronym }}"></a>
          @endcan
          @endforeach
			
			@if($cuenta == 0)
				<p>{{ trans('messages.profile_specialties_none') }}</p>
			@endif
		</div>
		
		@if($user->grants->count() > 0)
		<p>Medallas, diplomas y licencias</p>
		<div class="card-panel">
			<br>
			<?php $cuenta = 0; ?>
			@foreach($user->grants as $grant)
    			@continue(!($grant->badge->type == 0))
          		<?php $cuenta++; ?>
				<div class="row">
					<div class="col s4 m3 l2">
						@if(!is_null($grant->badge->image))
						<center><img height="50" class="materialboxed" data-caption="{{ $grant->badge->name }}" src="{{ url($grant->badge->image) }}" alt="{{ $grant->badge->name }}"></center>
						@endif
					</div>
					<div class="col s8 m9 l10 black-text">
					<b><a href="{{ route('badge', ['id' => $grant->badge->id]) }}">{{ $grant->badge->name }}</a></b>
					<br><span>@if(!is_null($grant->message)) "{{ $grant->message }}" @endif</span>
					</div>
				</div>
			@endforeach
			@if($cuenta > 0)
					<br>
			@endif
			<?php $cuenta = 0; ?>
			@foreach($user->grants as $grant)
    			@continue(!($grant->badge->type == 2))
          		<?php $cuenta++; ?>
				<div class="row">
					<div class="col s4 m3 l2">
					</div>
					<div class="col s8 m9 l10 black-text">
					<b><a href="{{ route('badge', ['id' => $grant->badge->id]) }}">{{ $grant->badge->name }}</a></b>
					<br><span>@if(!is_null($grant->message)) "{{ $grant->message }}" @endif</span>
					</div>
				</div>
			@endforeach
			@if($cuenta > 0)
					<br>
			@endif
			@foreach($user->grants as $grant)
    			@continue(!($grant->badge->type == 1))
				<div class="row">
					<div class="col s4 m3 l2">
					</div>
					<div class="col s8 m9 l10 black-text">
					<b><a href="{{ route('badge', ['id' => $grant->badge->id]) }}">{{ $grant->badge->name }}</a></b>
					<br><span>@if(!is_null($grant->message)) "{{ $grant->message }}" @endif</span>
					</div>
				</div>
			@endforeach
		</div>
		@endif

		@if(Auth::user()->isMando())

			@if($user->isWorking())
				<br>
				<div class="card-panel">
					<b>En servicio actualmente</b>
					<p>{{ $user->name }} se encuentra desde las {{ $user->getWork()->created_at->format('H:i') }}
						de servicio en "{{ $user->getWork()->gameSession->server->name }}".</p>
				</div>
			@endif

			<p>Servicios de los últimos dos meses</p>
			<div class="card-panel">
				<table class="highlight">
					<thead>
						<th>Tipo</th>
						<th>Duración</th>
						<th>Entrada</th>
						<th>Hora salida</th>
					</thead>
					<tbody>
						@foreach($user->works()->withoutGlobalScopes([App\Scopes\OngoingScope::class])->where([
						['created_at', '>', \Carbon\Carbon::now()->subMonths(2)],
						['end_reason', "!=", "cancel_user"],
						['end_reason', "!=", "cancel_offline"],
						['end_reason', "!=", "cancel_end"],
						])->orderBy('end_at', 'desc')->get() as $work)
						<tr>
							<td>
								@php
									$reason = "(?)";
									$reason_icon = null;
									switch ($work->end_reason) {
										case "user":
											$reason = "Finalizado";
											$reason_icon = 'done';
											break;
										case "cancel_user":
											$reason = "<20 min";
											$reason_icon = 'timer_off';
											break;
										case "offline":
											$reason = "Desconectado";
											$reason_icon = 'cloud_off';
											break;
										case "cancel_offline":
											$reason = "<20min desconectado";
											$reason_icon = 'timer_off';
											break;
										case "end":
											$reason = "Final del servicio";
											$reason_icon = 'done';
											break;
										case "cancel_end":
											$reason = "Final servicio <20min";
											$reason_icon = 'timer_off';
											break;
										case "kick":
											$reason = "Expulsado";
											$reason_icon = 'remove_circle_outline';
											break;
										default:
											$reason = null;
											$reason_icon = 'help_outline';
											break;
									}

								@endphp
								<i class="material-icons left">{{ $reason_icon }}</i> {{ $reason }}
							</td>
							<td>{{ is_null($work->end_at) ? "-" : gmdate('H:i:s', $work->end_at->diffInSeconds($work->created_at)) }}</td>
							<td>{{ $work->created_at->format("d/m/y H:i") }}</td>
							<td>{{ is_null($work->end_at) ? "-" : $work->end_at->format("H:i") }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif

		@if( Auth::user()->id != $user->id)
		<a href="{{ route('ticket_new', ['id' => $user->id]) }}" class="btn grey darken-1 waves-effect">{{ trans('messages.profile_complaint_button') }}</a>
		@endif

		@if(Auth::user()->id == $user->id || Auth::user()->isMando())
		<span class="right"><small><a href="#modalerror">{{ trans('messages.profile_error') }}</a></small></span>
		@endif
		 
		  

		  <!-- Modal Structure -->
		  <div id="modalerror" class="modal">
		    <div class="modal-content">
		      <h4>{{ trans('messages.profile_error_modal_title') }}</h4>
		      <p>{{ trans('messages.profile_error_modal_description') }}</p>
		    </div>
		    <div class="modal-footer">
		      <a href="#!" class=" modal-action modal-close waves-effect btn-flat">{{ trans('messages.profile_error_modal_close') }}</a>
		    </div>
		  </div>
		
		@can('admin')	
		<br><br>
		<span class="right">
		<a href="/admin/user/{{ $user->id }}/edit" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> {{ trans('messages.profile_admin_edit') }}</a>
		</span>
		@endcan

		
</div>
@endsection