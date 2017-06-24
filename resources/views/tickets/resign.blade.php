@extends('layouts.material')

@section('title', "Dimitir")

@section('content')


<div class="container">
<br>
	<h5>Dimitir</h5>

  @if (count($errors) > 0)
    <div class="card-panel">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

	@if(Auth::user()->isWorking())
        <div class="card-panel">
            <b>No se puede dimitir estando de servicio.</b>
            <p><a href="{{route('start-work')}}">Deja el servicio</a> e inténtalo de nuevo.</p>
        </div>
        @else
        <div class="card-panel">
            <div class="row">

                <form class="col s12" method="POST" action="{{ route('ticket_new_resign') }}">
                    {{ csrf_field() }}
                    <br>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="body" id="textarea1" class="materialize-textarea" placeholder="¿Por qué dejas la Policía?" length="1000">{{ old('body') }}</textarea>
                            <label for="textarea1">Carta de dimisión <span class="red-text">*</span></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" name="check1" class="filled-in" id="check1" @if(!is_null(old('check1'))) checked="checked" @endif />
                            <label for="check1">Entiendo que <b>no podré cometer delitos ni relacionarme con grupos organizados hasta que me acepten la dimisión</b></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" name="check2" class="filled-in" id="check2" @if(!is_null(old('check2'))) checked="checked" @endif />
                            <label for="check2"><b>No tengo armas ni nada ilegal como civil</b> y entiendo que no puedo llevarme material Policial</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" name="check3" class="filled-in" id="check3" @if(!is_null(old('check3'))) checked="checked" @endif />
                            <label for="check3">No entraré de servicio hasta que se revise la dimisión. Esto podría tardar hasta 48 horas.</label>
                        </div>
                    </div>
                    <br>
                    <p>Recuerda: sigues siendo Policía hasta que te acepten la dimisión. Se revisará tu inventario de civil, casas, etc.</p>

            </div>
            <button class="btn green white-text waves-effect">{{ trans('messages.newticket_send_button') }}</button>

            </form>
        </div>
    @endif
</div>


  <!-- Modal Structure -->
  <div id="modal_anonymous_mode" class="modal">
    <div class="modal-content">
      <h4>{{ trans('messages.newticket_anonymous_modal_title') }}</h4>
			{!! trans('messages.newticket_anonymous_modal_body') !!}

			<div class="card-panel deep-orange darken-4 white-text">
      	<p>{!! trans('messages.newticket_anonymous_modal_warning') !!}
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect btn-flat">{{ trans('messages.newticket_anonymous_modal_close_button') }}</a>
    </div>
  </div>

@endsection

@section('footer')
<script type="text/javascript">
$(document).ready(function() {
$('.js-example-basic-single').select2({
            placeholder: '{{ trans('messages.newticket_user_select_placeholder') }}',
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

function formatUser (state) {
  if (!state.id) { return state.text; }
  var $state = $(
    '<span><img height="16" src="/img/divisas/' + state.corp + '.png" class="img-flag" /> ' + state.text + ' (' + state.rank + ')</span>'
  );
  return $state;
};
</script>
@endsection
