@extends('layouts.material')

@section('title', trans('messages.menu_about'))

@section('content')

<div class="container">
<br>
	<h5>Acerca de</h5>

	<div class="card-panel">
		<p>Esta página ha sido desarrollada por Manolo Pérez (Apecengo) originalmente para la Policía de PoPLife (<a href="http://plataoplomo.wtf">Plata o Plomo</a>).
		<br>El código fuente está disponible para uso licenciado en <a href="https://github.com/apecengo/policia">este repositorio de Github</a>.</p>

		<p>El sitio está hecho en PHP con <a href="https://laravel.com">Laravel</a> 5.4, Laravel Backpack y <a href="http://materializecss.com">Materializecss</a>, entre otras cosas.</p>

		<p>Versión <a href="https://github.com/apecengo/policia/releases/tag/v{{ config('app.version') }}">v{{ config('app.version') }}</a></p>
	</div>
</div>

@endsection