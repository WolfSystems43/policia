@component('mail::message')
# Nueva queja interna

@if($ticket->anonymous)
Hay una nueva queja anónima, titulada:
@else
{{ $ticket->user->name }} ha publicado una queja titulada:
@endif

@component('mail::panel')
{{ $ticket->title }}
@endcomponent

Haz clic en el botón para acceder a ella:

@component('mail::button', ['url' => route('ticket', ['id' => $ticket->id])])
Ver queja
@endcomponent
@endcomponent
