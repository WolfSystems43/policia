@extends('layouts.material')

@section('title', 'Entrar de servicio')

@section('content')
    <div class="content">
        <div class="container">
            <br>

                <h5>Servicio</h5>
            <p>Selecciona el servidor donde vayas a entrar de servicio.</p>

                @if(session('name_error'))
                    <div class="card-panel">
                        <h5><i class="material-icons red-text left">error</i> No hemos detectado que estés conectado</h5>
                        <p>Tu nombre no está en la lista de usuarios conectados. Ten en cuenta:</p>
                        <ol>
                            <li>Tu nombre en el juego debe ser exactamente "{{ Auth::user()->name  }}", incluyendo mayúsculas/minúsculas y tildes. Las comillas no hay que ponerlas.</li>
                            <li>Nos conectamos al servidor una vez cada pocos minutos. Si justo ahora no puedes fichar, espera un par de minutos y vuélvelo a intentar.</li>
                        </ol>
                    </div>
                @endif
            @foreach($servers as $server)
                <div class="card-panel">
                        <div class="col s12">
                            @if($server->isOnline())
                                <span class="flow-text">{{ $server->name }}</span>
                                <small class="right hide-on-small-only">({{$server->getQuery()->get('gq_numplayers')}}/{{ $server->getQuery()->get('gq_maxplayers') }} {{ $server->getQuery()->get('gq_hostname')  }})</small>
                                @foreach($server->gameSessions as $gameSession)
                                    <p>Turno de <b>{{ $gameSession->getName() }}</b><br>
                                    @can('start-work', $gameSession)
                                        @if($gameSession->isClosed())
                                                <br><small>Este turno ha sido cerrado {{ $gameSession->end_at->subMinutes(10)->diffForHumans() }}. Por favor, espera al siguiente.</small>
                                                <br>
                                                <a class="btn blue waves-effect disabled"><i class="material-icons left">play_arrow</i> Entrar al servicio</a>
                                        @else
                                            <form action="{{ route('start-work') }}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="{{$gameSession->id}}">
                                                <button type="submit" href="" class="btn blue waves-effect"><i class="material-icons left">play_arrow</i> Entrar al servicio</button>
                                            </form>
                                        @endif
                                    @endcan
                                    @if($gameSession->start_at->isFuture())
                                        <span>
                                            <br>
                                            <i class="material-icons tiny">query_builder</i> Este turno no se ha abierto todavía.
                                            <br>
                                            <small>Vuelve {{ $gameSession->start_at->diffForHumans() }}.</small>
                                        </span>
                                    @endif
                                    </p>
                                    @if($gameSession->works()->count() > 0)
                                        <small>
                                            Compañeros en el servicio ({{$gameSession->works()->count()}}):
                                        @foreach($gameSession->works as $work)
                                            {{ $work->user->name }}@if(Auth::user()->isMando()) ({{ $work->created_at->format('H:i') }})@endif @if(!$loop->last)- @endif
                                        @endforeach
                                        </small>
                                    @endif
                                @endforeach
                                @if($server->gameSessions()->count() == 0)
                                    <p>Ahora mismo no hay ningún turno disponible en este servidor.
                                        <br><small>Posiblemente sea un error, ponte en contacto con la Jefatura.</small>
                                    </p>
                                @endif
                            @else
                                        <span class="flow-text">{{ $server->name }}</span>
                                <br><br>
                                <span>No hemos podido conectarnos con el servidor.<br><small>Lo intentaremos de nuevo en un minuto.</small></span>
                            @endif
                        </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection