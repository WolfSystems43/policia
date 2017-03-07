@component('mail::message')
# Han respondido a tu queja

Hay una nueva respuesta a tu queja:

@component('mail::panel')
{{ $reply->body }}
@endcomponent

<br>Para ver la queja y responder, haz clic en el siguiente botón:

@component('mail::button', ['url' => route('ticket', ['id' => $reply->ticket->id])."#reply-".$reply->id])
Ver queja
@endcomponent
@endcomponent