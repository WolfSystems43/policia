@extends('layouts.material')

@section('content')
	

<div class="container">
<br>
	<h5>Presentar queja interna</h5>
  
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

    @if(!is_null($user))
    <form class="col s12" method="POST" action="{{ route('ticket_new', ['id' => $user->id]) }}">
    @else
    <form class="col s12" method="POST" action="{{ route('ticket_new') }}">
    @endif
	{{ csrf_field() }}
       <div class="row">
        <div class="input-field col s12">
          <p>Personas de las que te quejas <span class="red-text">*</span></p>
			<select style="width: 100%" name="implicated[]" class="js-example-basic-single browser-default" multiple="multiple" required="required">
        @if(!is_null(old('implicated')))
          @foreach(old('implicated') as $id)
            <option value="{{ $id }}" selected="selected">{{ \App\User::findOrFail($id)->name }}</option>
          @endforeach
        @else
          @if(!is_null($user))
				  <option value="{{ $user->id }}" selected="selected">{{ $user->name }}</option>
          @endif
        @endif
			</select>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input id="title" name="title" type="text" class="validate" placeholder="Algo corto y explicativo" length="100" value="{{ old('title') }}">
          <label for="text">Asunto <span class="red-text">*</span></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <textarea name="body" id="textarea1" class="materialize-textarea" placeholder="Incluir todos los detalles posibles. Obligatorio añadir pruebas." length="1000">{{ old('body') }}</textarea>
          <label for="textarea1">Descripción de los hechos <span class="red-text">*</span></label>
        </div>
      </div>
    <p>Consejos para hacer una buena queja:</p>
    <ol>
      <li>Incluye hora, fecha, servidor, y demás información circunstancial.</li>
      <li>Aporta pruebas poniendo entre (paréntesis) imágenes subidas a <a href="https://imgur.com">Imgur</a>, Vídeos de <a href="https://youtube.com">YouTube</a>, <a href="https://twitch.tv">Twitch</a>, <a href="http://plays.tv/">Plays TV</a>, etc.</li>
      <li>Añade en la lista de personas de las que te quejas a todos aquellos que creas que hicieron algo mal. Explica uno por uno su implicación.</li>
    </ol>
		<p><b>Toda queja debe estar apoyada por pruebas acordes al nivel de la acusación.</b></p>

      <div class="row">
        <div class="input-field col s12">
          <input type="checkbox" name="anonymous" class="filled-in" id="filled-in-box" @if(!is_null(old('anonymous'))) checked="checked" @endif />
      		<label for="filled-in-box">Mantener el anonimato <a href="#modal_anonimato">más información</a></label>
        </div>
      </div>

  </div>
	<button class="btn green white-text waves-effect">Enviar</button>

    </form>
	</div>
</div>
	

  <!-- Modal Structure -->
  <div id="modal_anonimato" class="modal">
    <div class="modal-content">
      <h4>Modo anónimo</h4>
      <p>Si seleccionas el modo anónimo, tu nombre no aparecerá en el panel de gestión de quejas internas.</p>

      <p>Esto está pensado para presentar quejas contra miembros de la jefatura principalmente, aunque también puedes optar por activar el modo anónimo aunque no sean quejas contra gente de rango alto.</p>

      <p>Aunque actives el modo anónimo, podrás comunicarte si lo deseas a través de esta misma web, siempre manteniendo un riguroso anonimato.</p>

      <p>Ten en cuenta que, dependiendo de tu forma de escribir, los responsables podrían deducir tu identidad.</p>

      <p>Una vez activado el anonimato, no podrás desacivarlo en esa misma incidencia.</p>

      <div class="card-panel deep-orange darken-4 white-text">
      	<p><b>Aviso:</b> en casos de faltas de respeto o similar los comisarios podrán solicitar a cierto miembro del staff que revele el nombre del denunciante. Se valorará la situación y puede darse el caso de que se comunique.</p>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect btn-flat">Cerrar</a>
    </div>
  </div>

@endsection

@section('footer')
<script type="text/javascript">
$(document).ready(function() {
$('.js-example-basic-single').select2({
            placeholder: 'Introduce uno o varios nombres',
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