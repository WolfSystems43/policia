@extends('layouts.material')

@section('title', trans('messages.home_title'))

@section('content')
<div class="section">
    <div class="container">

        <div class="row">

            <div class="col s12 m4">
               <p>Enlaces rápidos</p>
               <div class="row">
                @foreach($links as $link)
                    <div class="col s12">
                        <a href="{{ url($link[1]) }}">
                            <div class="card-panel hoverable truncate">
                                <i class="left material-icons">{{ $link[2] }}</i> {{ $link[0] }}    
                            </div>
                        </a>
                    </div>
                @endforeach
                </div>
            </div>

            <div class="col s12 m8">
                <p>Comunicados internos</p>
                <div class="row">
                    <div class="col s12">  
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

                        <span class="right"><a href="{{ route('posts') }}">ver más comunicados</a></span>
                    </div>
                </div>

        @can('admin-tickets')
        @if($tickets_open > 0)
        <p><img height="16" src="/img/divisas/especialidades/6.png"> {{ trans('messages.home_tickets_waiting') }}</p>
        <div class="card-panel">
            <p><a href="{{ route('tickets') }}">{{ trans_choice('messages.home_tickets_waiting_content', $tickets_open, ['num' => $tickets_open]) }}</a></p>
        </div>
        @endif 
        @endcan

        @if($tickets->count() > 0)
        <p>Tus tickets abiertos</p>
            <ul>
            @foreach($tickets as $ticket)
            <a href="{{ route('ticket', ['id' => $ticket->id]) }}">
            <div class="card-panel hoverable">
                <div class="row">
                    <div class="col s12 m6">
                        <span><b>{{ $ticket->title }}</b></span>
                        <br><span>{{ $ticket->getCreatedDiff() }}</span>
                    </div>
                    <div class="col s12 m6">
                        <span>{!! trans_choice('messages.home_tickets_open_replies', $ticket->replies->count(), ['num' => $ticket->replies->count()]) !!}
                        @if($ticket->replies->count() > 0) 
                        ({{ $ticket->getLastReply()->getCreatedDiff() }})</span>
                        @endif
                        <br><span><i class="material-icons tiny">{{ $ticket->getStatus()['icon'] }}</i> {{ $ticket->getStatus()['text'] }}</span>
                    </div>
                </div>
            </div>
            </a>
            @endforeach
            </ul>
        @endif


            </div>

        </div> 


    </div>
</div>

@endsection
