@extends('layouts.material')

@section('title', trans('messages.home_title'))

@section('content')
<div class="section">
    <div class="container">

        @foreach($posts as $post)

	        @if ($loop->first)
	            <div class="card-panel @if($post->isNew()) new-indicator @endif ">
	                <span><b><a href="{{ route('post', ['id' => $post->id]) }}">{{ $post->title }}</a></b> <small>- {{ $post->getCreatedDiff() }}</small> 

	                @if($post->isNew())  <span class="new badge blue" data-badge-caption="">Nuevo</span> @endif
	                </span>
	                
	                <?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($post->content); ?>
	            </div>
	        @else
	            <div class="card-panel">
	                <p>
	                <a href="{{ route('post', ['id' => $post->id]) }}">{{ $post->title }}</a> <small>- {{ $post->getCreatedDiff() }}</small>
	                @if($post->isNew())  <span class="new badge blue" data-badge-caption="">Nuevo</span> @endif
	                </p>
	            </div>
	        @endif

        @endforeach

        {{ $posts->links() }}

    </div>
</div>

@endsection
