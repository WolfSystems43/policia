@extends('layouts.material')

@section('title', $badge->name)

@section('content')

<div class="container">
	
	@if($badge->type == 0)
		<br>
		<div class="row">
			<div class="col s12 m4">
				<div class="card-panel">
					<center><img height="200" src="{{ url($badge->image) }}" alt="{{ $badge->name }}"></center>
				</div>
			</div>
			<div class="col s12 m8">
				<div class="card-panel">
					<h5>{{ $badge->name }}</h5>
            		<?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($badge->description); ?>
				</div>
				
				<br>
				<p>Concesiones</p>
				<div class="card-panel">
					@foreach($badge->grants as $grant)
					  <div class="chip">
					    <a href="{{ route('user_profile', ['id' => $grant->user->id]) }}">{{ $grant->user->name }}</a>
					  </div>
					@endforeach
				</div>

			</div>
		</div>
	@endif

	@if($badge->type > 0)
		<br>
		<div class="card-panel">
			<h5>{{ $badge->name}}</h5>

            <?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($badge->description); ?>
		</div>
		
		<br>
		<p>Concesiones</p>
		<div class="card-panel">
			@foreach($badge->grants as $grant)
			  <div class="chip">
			    <a href="{{ route('user_profile', ['id' => $grant->user->id]) }}">{{ $grant->user->name }}</a>
			  </div>
			@endforeach
		</div>
	@endif

</div>


@endsection