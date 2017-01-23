@extends('layouts.material')

@section('title', 'Lista de personal')

@section('content')

<div class="container">
  <br>
    <div class="row">
      <div class="col s3 m1"> 
        <img height="85" src="/img/divisas/cnp.png"> 
      </div>
      <div class="col s9 m11">
<span><small class="right">última actualización {{ $last }}</small></span>
        <h5>Cuerpo Nacional de Policía</h5>
        <span>{{ $cnp->count() }} en total.</span>
      </div>
    </div>

	<div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="rank">Rango</th>
              <th data-field="name">Nombre</th>
              <th data-field="name">Especialidades</th>
          </tr>
        </thead>

        <tbody>
        @foreach($cnp as $user)
              <tr>
                <td> <img class="left" height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
    			@if($user->rank >= 9)
                 <b>{{ $user->getRankName() }}</b>
                @elseif($user->rank <= 1)
                 <i>{{ $user->getRankName() }}</i>
                @else
                 {{ $user->getRankName() }}
                @endif
                </td>
                <td><a href="{{ route('user_profile', $user->id) }}">{{ $user->name }}</a></td>
                <td>
    			@foreach($user->specialties()->get() as $specialty)
          @can('view-secret-specialty', $specialty)
          <a href="{{ route('specialty-view', ['id' => $specialty->id]) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="{{ $specialty->acronym }}"><img height="24" src="/img/divisas/especialidades/{{ $specialty->id }}.png" alt="{{ $specialty->acronym }}"></a>
          @endcan
    			@endforeach
                </td>
              </tr>
        @endforeach

        </tbody>
      </table>
      </div>




<br>
    <div class="row">
      <div class="col s3 m1"> 
        <img height="85" src="/img/divisas/gc.png"> 
      </div>
      <div class="col s9 m11">
        <h5>Guardia Civil</h5>
        <span>{{ $gc->count() }} en total.</span>
      </div>
    </div>

  <div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="rank">Rango</th>
              <th data-field="name">Nombre</th>
              <th data-field="name">Especialidades</th>
          </tr>
        </thead>

        <tbody>
        @foreach($gc as $user)
              <tr>
                <td> <img class="left" height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
          @if($user->rank >= 9)
                 <b>{{ $user->getRankName() }}</b>
                @elseif($user->rank <= 1)
                 <i>{{ $user->getRankName() }}</i>
                @else
                 {{ $user->getRankName() }}
                @endif
                </td>
                <td><a href="{{ route('user_profile', $user->id) }}">{{ $user->name }}</a></td>
                <td>
          @foreach($user->specialties()->get() as $specialty)
          @can('view-secret-specialty', $specialty)
          <a href="{{ route('specialty-view', ['id' => $specialty->id]) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="{{ $specialty->acronym }}"><img height="24" src="/img/divisas/especialidades/{{ $specialty->id }}.png" alt="{{ $specialty->acronym }}"></a>
          @endcan
          @endforeach
                </td>
              </tr>
        @endforeach

        </tbody>
      </table>
      </div>






<br>
    <div class="row">
      <div class="col s3 m1"> 
        <img height="85" src="/img/divisas/cnpgc.png"> 
      </div>
      <div class="col s9 m11">
        <h5>Elección de cuerpo</h5>
        <span>{{ $cadetes->count() }} en total.</span>
      </div>
    </div>

  <div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="rank">Rango</th>
              <th data-field="name">Nombre</th>
              <th data-field="name">Especialidades</th>
          </tr>
        </thead>

        <tbody>
        @foreach($cadetes as $user)
              <tr>
                <td> <img class="left" height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
          @if($user->rank >= 9)
                 <b>{{ $user->getRankName() }}</b>
                @elseif($user->rank <= 1)
                 <i>{{ $user->getRankName() }}</i>
                @else
                 {{ $user->getRankName() }}
                @endif
                </td>
                <td><a href="{{ route('user_profile', $user->id) }}">{{ $user->name }}</a></td>
                <td>
          @foreach($user->specialties()->get() as $specialty)
          @can('view-secret-specialty', $specialty)
          <a href="{{ route('specialty-view', ['id' => $specialty->id]) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="{{ $specialty->acronym }}"><img height="24" src="/img/divisas/especialidades/{{ $specialty->id }}.png" alt="{{ $specialty->acronym }}"></a>
          @endcan
          @endforeach
                </td>
              </tr>
        @endforeach

        </tbody>
      </table>
      </div>






  </div>


  </div>

  </div>



</div>



@endsection