@extends('layouts.material')

@section('title', trans('messages.home_title'))

@section('content')
<div class="section">
    <div class="container">

        <span><small><a href="{{ route('posts') }}">{{ trans('messages.post_back') }}</a></small></span>

        <br>
        <h5>{{ $post->title }}</h5>

        <div class="card-panel">
            <?php echo GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($post->content); ?>
        </div>

        <span><small>
          {!! trans('messages.post_footer', [
            'route' => route('user_profile', ['id' => $post->user->id]),
            'name' => $post->user->name,
            'ago' => $post->getCreatedDiff(),
            ]) !!}


        </small></span>

    </div>
</div>

@endsection
