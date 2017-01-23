@extends('layouts.material')

@section('title', 'Página principal')

@section('content')
<div class="section">
    <div class="container">
    	<div class="row">
	    	@foreach($links as $link)
	    		<div class="col s6 m3">
	    			<a href="{{ url($link[1]) }}">
		    			<div class="card-panel hoverable">
		    				<i class="left material-icons">{{ $link[2] }}</i> {{ $link[0] }}	
		    			</div>
	    			</a>
	    		</div>
			@endforeach
    	</div>
    </div>
</div>

@endsection
