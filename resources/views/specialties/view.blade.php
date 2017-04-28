@extends('layouts.material')

@section('title', $specialty->acronym)

@section('content')
	<div class="container">
	<br>
		<div class="row">
			<div class="col s6 m1">	
				<img height="85" src="/img/divisas/especialidades/{{ $specialty->id }}.png"> 
			</div>
			<div class="col s6 m11">
				<h5>{{ $specialty->acronym }}</h5>
				<span>{{ $specialty->name }}</span>
			</div>
		</div>
		
		@if(!is_null($specialty->description))
		<p>{{ trans('messages.specialty_description') }}</p>
		<div class="card-panel">
			
		<?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($specialty->description); ?>
		</div>
		@endif

		@can('view-specialty-message', $specialty)
		@if(!is_null($specialty->message))
			<p>{{ trans('messages.specialty_members_message') }}</p>
			<div class="card-panel">
				<?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($specialty->message); ?>
			</div>
		@endif
		@endcan


		@can('view-secret-specialty', $specialty)
		@if($specialty->secret)
		<p>{{ trans('messages.specialty_classified') }}</p>
		<div class="card-panel">
			<p>Este grupo se considera secreto. Está prohibido compartir sus miembros, funcionamiento, etc. 
			@if(Auth::user()->isMando())
				<br><i>Puedes ver esto porque eres mando de la Policía.</i>
			@endif
			</p>
		</div>
		@endif




		<p>{{ trans('messages.specialty_members', ['num' => $specialty->users->count()]) }}</p>

		<div class="card-panel">
			<table class="highlight">
	        <thead>
	          <tr>
	              <th data-field="corp">{{ trans('messages.specialty_corp') }}</th>
	              <th data-field="rank">{{ trans('messages.specialty_rank') }}</th>
	              <th data-field="name">{{ trans('messages.specialty_name') }}</th>
	          </tr>
	        </thead>

	        <tbody>
	        @foreach($specialty->users()->orderBy('name', 'asc')->get() as $user)
	          <tr>
	            <td><img height="24" class="left list-img" src="{{ $user->getCorpImage() }}" alt=" Insignia {{ $user->getCorpName() }}"> {{ $user->getCorpName() }}</td>
	            <td> <img height="24" class="left list-img" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
				@if($user->rank >= 9)
	             <b>{{ $user->getRankName() }}</b>
	            @elseif($user->rank <= 1)
	             <i>{{ $user->getRankName() }}</i>
	            @else
	             {{ $user->getRankName() }}
	            @endif
	            </td>
	            <td><a href="{{ route('user_profile', $user->id) }}">{{ $user->name }}</a></td>
	          </tr>
	        @endforeach

	        </tbody>
	        </table>
		</div>

		<p><small>{{ trans('messages.specialty_last_update', ['ago' => $specialty->getLastUpdatedDiff()]) }}
		
		@if(!is_null($specialty->user))
		<span class="small right">{{ trans('messages.specialty_boss') }}  <a href="{{ route('user_profile', $specialty->user->id) }}">{{ $specialty->user->getRankName() }} {{ $specialty->user->name }}</a></span>
		@endif
		</small></p>
		@endcan
		@cannot('view-secret-specialty', $specialty)
		<p>Información</p>
		<div class="card-panel">
			Esta especialización contiene información confidencial que solo los miembros pueden ver.
			
			@if(!is_null($specialty->user))
				<p>Responsable de la unidad:  <a href="{{ route('user_profile', $specialty->user->id) }}">{{ $specialty->user->getRankName() }} {{ $specialty->user->name }}</a></p>
			@endif
		</div>
		@endcannot


		@can('admin')	
		<span class="right">
		<a href="/admin/specialty/{{ $specialty->id }}/edit" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> {{ trans('messages.specialty_admin_edit') }}</a>
		</span>
		@endcan

	</div>
@endsection