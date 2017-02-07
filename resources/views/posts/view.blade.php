@extends('layouts.material')

@section('title', trans('messages.home_title'))

@section('content')
<div class="section">
    <div class="container">
    
        <span><small><a href="{{ route('posts') }}"><< lista de comunicados</a></small></span>

        <br>
        <h5>{{ $post->title }}</h5> 
        
        <div class="card-panel">
            <?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($post->content); ?>
        </div>

        <span><small>Por <a href="{{ route('user_profile', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a> {{ $post->getCreatedDiff() }}</small></span>

    </div>
</div>

@endsection
