@extends('layouts.material')

@section('title', 'Lista de personal')

@section('content')

<div class="container">
  <br>
  <div class="col s12">
    <div class="row">
      <div class="col s6">
        <select id="user_search" style="width: 100%" name="implicated[]" class="js-example-basic-single browser-default" required="required">
        </select>
      </div>
      <div class="col s6">
          <span><small class="right">{{ trans('messages.list_last_update', ['ago' =>$last ]) }}</small></span>
      </div>
    </div>
  </div>

  <br>
    <div class="row">


      <div class="col s3 m1">
        <img height="85" src="/img/divisas/cnp.png">
      </div>
      <div class="col s9 m11">
        <h5>Cuerpo Nacional de Policía</h5>
        <span>{{ trans('messages.list_total', ['num' => $cnp->count()]) }}</span>
      </div>
    </div>

	<div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="rank">{{ trans('messages.list_rank') }}</th>
              <th data-field="name">{{ trans('messages.list_name') }}</th>
              <th data-field="name">{{ trans('messages.list_specialties') }}</th>
          </tr>
        </thead>

        <tbody>
        @foreach($cnp as $user)
              <tr @if($user->isWorking()) class="green lighten-4" @endif>
                <td> <img class="left list-img" height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
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
        <span>{{ trans('messages.list_total', ['num' => $gc->count()]) }}</span>
      </div>
    </div>

  <div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="rank">{{ trans('messages.list_rank') }}</th>
              <th data-field="name">{{ trans('messages.list_name') }}</th>
              <th data-field="name">{{ trans('messages.list_specialties') }}</th>
          </tr>
        </thead>

        <tbody>
        @foreach($gc as $user)
              <tr @if($user->isWorking()) class="green lighten-4" @endif>
                <td> <img class="left list-img" height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
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
        <span>{{ trans('messages.list_total', ['num' => $cadetes->count()]) }}</span>
      </div>
    </div>

  <div class="card-panel">
      <table class="highlight">
        <thead>
          <tr>
              <th data-field="rank">{{ trans('messages.list_rank') }}</th>
              <th data-field="name">{{ trans('messages.list_name') }}</th>
              <th data-field="name">{{ trans('messages.list_specialties') }}</th>
          </tr>
        </thead>

        <tbody>
        @foreach($cadetes as $user)
              <tr @if($user->isWorking()) class="green lighten-4" @endif>
                <td> <img class="left list-img" height="24" src="{{ $user->getRankImage() }}" alt="Divisa de {{ $user->getRankName() }}">
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
@section('footer')
<script type="text/javascript">
$(document).ready(function() {
$('.js-example-basic-single').select2({
            placeholder: '{{ trans('messages.list_search_placeholder') }}',
            language: "es",
            templateResult: formatUser,
      			minimumInputLength: 3,
      			maximumSelectionLength: 30,
            ajax: {
                dataType: 'json',
                url: '{{ route("api_user_search_input") }}',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
            }
        });
});

$('#user_search').change(function() {
  // set the window's location property to the value of the option the user has selected
  window.location = "/usuario/" + $(this).val();
});

function formatUser (state) {
  if (!state.id) { return state.text; }
  var $state = $(
    '<span><img height="16" src="/img/divisas/' + state.corp + '.png" class="img-flag" /> ' + state.text + ' (' + state.rank + ')</span>'
  );
  return $state;
};
</script>
@endsection
