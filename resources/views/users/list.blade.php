@extends('layouts.material')

@section('title', 'Lista de personal')

@section('content')

<div class="container">

	<br>
	<h5>Lista de personal</h5>
	<div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="corp">Cuerpo</th>
              <th data-field="rank">Rango</th>
              <th data-field="name">Nombre</th>
              <th data-field="name">Especialidades</th>
          </tr>
        </thead>

        <tbody>
        @foreach($users as $user)
          <tr>
            <td><img height="24" src="{{ $user->getCorpImage() }}" alt=" Insignia {{ $user->getCorpName() }}"> {{ $user->getCorpName() }}</td>
            <td> <img height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
			@if($user->rank >= 9)
             <b>{{ $user->getRankName() }}</b>
            @elseif($user->rank <= 1)
             <i>{{ $user->getRankName() }}</i>
            @else
             {{ $user->getRankName() }}
            @endif
            </td>
            <td>{{ $user->name }}</td>
            <td>
			@foreach($user->specialties()->get() as $specialty)
			<img height="24" src="/img/divisas/especialidades/{{ $specialty->id }}.png" alt="{{ $specialty->acronym }}">
			@endforeach
            </td>
          </tr>
        @endforeach

        </tbody>
        </table>
        </div>
        </div>

</div>



@endsection