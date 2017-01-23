@extends('layouts.material')

@section('title', 'Frecuencias')

@section('content')
<div class="section">
    <div class="container">
    	<div class="row">
    		<div class="col s12 l6">
        		<h5>Frecuencias <small title="Generado por {{ $frequency->user->name }}">{{ $frequency->getLastStatusDiff() }}</small></h5>
    		</div>
    		<div class="col s12 l6">
    		</div>
    	</div>
        <div class="card-panel">
              <table class="highlight">
		        <thead>
		          <tr>
		              <th data-field="id">Nombre</th>
		              <th data-field="name">Frecuencia</th>
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
				<p><b>Regenerar frecuencias</b></p>
		      <p>Como mando, puedes regenerar las frecuencias. A tener en cuenta:</p>
		      <ol>
		      	<li>Las frecuencias se regeneran para ambos servidores</li>
		      	<li>Para regenerar de cara a un reinicio, debe ser como mínimo menos 5.</li>
		      </ol>
		      	<form action="{{ route('frequencies_new') }}" method="POST" onsubmit="return confirm('¿Regenerar ferecuencias?');">
		      	{{ csrf_field() }}
		      	<button class="btn">Regenerar frecuencias</button>
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
