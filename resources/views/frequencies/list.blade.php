@extends('layouts.material')

@section('title', trans('messages.frequencies_title'))

@section('content')
<div class="section">
    <div class="container">
    	<div class="row">
    		<div class="col s12 l6">
        		<h5>{{ trans('messages.frequencies_title') }} <small title="{{ trans('messages.frequencies_last_updated_user', ['name' => $frequency->user->name]) }}">{{ $frequency->getLastStatusDiff() }}</small></h5>
    		</div>
    		<div class="col s12 l6">
    		</div>
    	</div>

      <div class="card-panel" id="freq_warning">
        <span class="flow-text">Solo para agentes de servicio</span>
        <p>Las frecuencias son solo para aquellos que estén de servicio.</p>
        <button class="btn blue waves-effect" id="freq_warning_button">Mostrar</button>
      </div>

        <div class="card-panel hidden" id="frecuencias" style="display:none">
              <table class="highlight">
		        <thead>
		          <tr>
		              <th data-field="id">{{ trans('messages.frequencies_name') }}</th>
		              <th data-field="name">{{ trans('messages.frequencies_frequency') }}</th>
		          </tr>
		        </thead>

		        <tbody>
	            @foreach($frequencies as $freq)
		          <tr>
		            <td>{{$freq[0]}}</td>
		            <td><span class="spoiler">{{$freq[1]}}</span></td>
		          </tr>
	            @endforeach
		        </tbody>
		      </table>
				@can('regenerate-frequencies')
				<div class="divider"></div>
				<p><b>{{ trans('messages.frequencies_regenerate_title') }}</b></p>
		      {!! trans('messages.frequencies_regenerate_subtitle') !!}
		      	<form action="{{ route('frequencies_new') }}" method="POST" onsubmit="return confirm('{{ trans('messages.frequencies_regenerate_confirm') }}');">
		      	{{ csrf_field() }}
		      	<button class="btn waves-effect waves-light black">{{ trans('messages.frequencies_regenerate_button') }}</button>
		      	</form>
        		@endcan
		      </div>



				<br>
				<span class="flow-text">Contraseña canales TeamSpeak</span>
				<div class="card-panel">
					<p>Utiliza esta contraseña para acceder a los canales privados de la Policía cuando estés fuera de servicio:</p>

					<span class="spoiler">{{ Config::get('settings.ts_password') }}</span>
				@can('admin')
				<span class="right">
				<a href="/admin/setting/1/edit" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> Editar</a>
				</span>
				<br><br>
				@endcan
				</div>



    </div>
</div>

@endsection

@section('footer')
  <script>
  $('#freq_warning_button').on('click', function(e) {
    $('#freq_warning_button').addClass('disabled');
    setTimeout(function() {
      $('#freq_warning').hide();
      $('#frecuencias').show();
    }, 1000);
  });
  </script>
@endsection
