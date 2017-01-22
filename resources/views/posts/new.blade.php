@extends('layouts.material')

@section('content')

<div class="container">
<br>
	<h5>Nuevo post</h5>

	<div class="card-panel">
 <div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input id="title" name="title" type="text" class="validate">
          <label for="text">Título</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <textarea id="textarea1" class="materialize-textarea"></textarea>
          <label for="textarea1">Contenido</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
		    <select required="required">
		      <option value="" disabled selected>Seleccionar rango...</option>
		      <optgroup label="Recién llegados">
		      	<option value="1" selected="selected">Recluta/Cadete</option>
		      </optgroup>
		      <optgroup label="Agentes">
			      <option value="2">Agente</option>
			      <option value="3">Agente Primero</option>
			      <option value="4">Agente Segundo</option>
			      <option value="5">Suboficial/Cabo</option>
			      <option value="6">Oficial en Prácticas/Cabo Primero</option>
			      <option value="7">Oficial/Cabo Mayor</option>
			      <option value="8">Subinspector/Sargento</option>
		      </optgroup>
		      <optgroup label="Mandos">
			      <option value="9">Inspector/Teniente</option>
			      <option value="10">Inspector/Coronel</option>
		      </optgroup>
		      <optgroup label="Comisarios">
			      <option value="11">Comisario</option>
			      <option value="12">Comisario principal</option>
		      </optgroup>
		    </select>
		    <label>Rango mínimo para ver</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input type="checkbox" class="filled-in" id="filled-in-box"/>
      		<label for="filled-in-box">Anunciar en todas las páginas de la intranet</label>
        </div>
      </div>

  </div>
	<button class="btn black white-text">Enviar</button>

    </form>
	</div>
</div>

@endsection